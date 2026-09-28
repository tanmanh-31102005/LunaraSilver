<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Order;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use App\Services\SupportEmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SupportController extends Controller
{
    /**
     * Display FAQ and Support Center landing page.
     */
    public function faq(Request $request): View
    {
        $searchQuery = trim((string) $request->input('q', ''));
        $selectedCategory = $request->input('category');

        $query = Faq::active()->orderBy('sort_order')->orderBy('id');

        if ($selectedCategory && in_array($selectedCategory, Faq::CATEGORIES, true)) {
            $query->where('category', $selectedCategory);
        }

        if ($searchQuery !== '') {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('question', 'like', "%{$searchQuery}%")
                    ->orWhere('answer', 'like', "%{$searchQuery}%")
                    ->orWhere('category', 'like', "%{$searchQuery}%");
            });
        }

        $faqs = $query->get()->groupBy('category');
        $categories = Faq::CATEGORIES;

        return view('support.faq', compact('faqs', 'categories', 'selectedCategory', 'searchQuery'));
    }

    /**
     * Display the Contact Form page.
     */
    public function contact(Request $request): View
    {
        $user = auth()->user();
        $userOrders = collect();
        $selectedOrder = null;

        if ($user) {
            $userOrders = Order::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->limit(20)
                ->get();

            $orderParam = $request->input('order_id') ?? $request->input('order');
            if ($orderParam) {
                $selectedOrder = Order::where('user_id', $user->id)
                    ->where(function ($q) use ($orderParam) {
                        $q->where('id', $orderParam)->orWhere('order_code', $orderParam);
                    })
                    ->first();
            }
        }

        return view('support.contact', compact('user', 'userOrders', 'selectedOrder'));
    }

    /**
     * Process contact form submission with anti-spam & email notifications.
     */
    public function submitContact(Request $request, SupportEmailService $emailService): RedirectResponse
    {
        // 1. Anti-spam: Rate limiting (5 per 10 minutes per IP)
        $ip = $request->ip();
        $limiterKey = 'contact_submission:'.$ip;

        if (RateLimiter::tooManyAttempts($limiterKey, 5)) {
            $seconds = RateLimiter::availableIn($limiterKey);

            return back()
                ->withInput()
                ->withErrors(['rate_limit' => "Quý khách đã gửi nhiều yêu cầu liên tiếp. Vui lòng thử lại sau {$seconds} giây."]);
        }

        // 2. Anti-spam: Honeypot check
        if (! empty($request->input('_hp_website'))) {
            // Silently ignore bot submission
            return back()->with('success', 'Yêu cầu của quý khách đã được ghi nhận.');
        }

        // 3. Validation
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:3000',
            'order_id' => 'nullable|integer',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên của quý khách.',
            'email.required' => 'Vui lòng cung cấp địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'subject.required' => 'Vui lòng nhập tiêu đề hoặc chủ đề cần hỗ trợ.',
            'message.required' => 'Vui lòng nhập nội dung chi tiết cần hỗ trợ.',
            'message.min' => 'Nội dung yêu cầu phải có ít nhất 10 ký tự.',
            'message.max' => 'Nội dung yêu cầu tối đa 3000 ký tự.',
        ]);

        // 4. Order ownership rule: Guest cannot pass arbitrary order_id; auth user can only pass owned order
        $orderId = null;
        if (! empty($validated['order_id'])) {
            if (! auth()->check()) {
                return back()
                    ->withInput()
                    ->withErrors(['order_id' => 'Khách vãng lai không thể liên kết trực tiếp mã đơn hàng. Vui lòng đăng nhập hoặc ghi mã đơn vào phần nội dung.']);
            }

            $order = Order::where('id', $validated['order_id'])
                ->where('user_id', auth()->id())
                ->first();

            if (! $order) {
                return back()
                    ->withInput()
                    ->withErrors(['order_id' => 'Đơn hàng đã chọn không tồn tại hoặc không thuộc quyền sở hữu của quý khách.']);
            }

            $orderId = $order->id;
        }

        RateLimiter::hit($limiterKey, 600);

        // 5. Save to database first (Commit before sending email)
        $contactMessage = ContactMessage::create([
            'user_id' => auth()->id(),
            'order_id' => $orderId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => ContactMessage::STATUS_NEW,
        ]);

        // 6. Asynchronous / safe synchronous email sending
        $emailService->sendCustomerReceived($contactMessage);
        $emailService->sendAdminNewRequest($contactMessage);

        return back()->with('success', 'Yêu cầu của bạn đã được ghi nhận. Lunara sẽ phản hồi trong thời gian sớm nhất qua email.');
    }

    /**
     * Initialize or resume live chat session.
     */
    public function initChat(Request $request): JsonResponse
    {
        $user = auth()->user();

        if ($user) {
            $conversation = SupportConversation::where('user_id', $user->id)
                ->whereIn('status', [SupportConversation::STATUS_OPEN, SupportConversation::STATUS_ASSIGNED])
                ->latest()
                ->first();

            if (! $conversation) {
                $conversation = SupportConversation::create([
                    'user_id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'status' => SupportConversation::STATUS_OPEN,
                    'last_message_at' => now(),
                ]);
            }
        } else {
            $guestToken = $request->session()->get('support_guest_token');
            if (! $guestToken) {
                $guestToken = Str::random(60);
                $request->session()->put('support_guest_token', $guestToken);
            }

            $conversation = SupportConversation::where('guest_token', $guestToken)
                ->whereIn('status', [SupportConversation::STATUS_OPEN, SupportConversation::STATUS_ASSIGNED])
                ->latest()
                ->first();

            if (! $conversation) {
                $conversation = SupportConversation::create([
                    'guest_token' => $guestToken,
                    'customer_name' => 'Khách vãng lai',
                    'status' => SupportConversation::STATUS_OPEN,
                    'last_message_at' => now(),
                ]);
            }
        }

        // Mark admin messages read
        $conversation->messages()
            ->where('sender_type', SupportMessage::SENDER_ADMIN)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender_type' => $msg->sender_type,
                    'sender_name' => $msg->sender_name,
                    'message' => $msg->message,
                    'time' => $msg->created_at->format('H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'conversation' => [
                'reference' => $conversation->reference,
                'status' => $conversation->status,
                'status_label' => SupportConversation::STATUS_LABELS[$conversation->status] ?? $conversation->status,
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Poll new chat messages for customer.
     */
    public function getChatMessages(Request $request, string $reference): JsonResponse
    {
        $conversation = $this->authorizeConversationAccess($request, $reference);
        if (! $conversation) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy phiên hỗ trợ.'], 403);
        }

        // Mark admin messages as read
        $conversation->messages()
            ->where('sender_type', SupportMessage::SENDER_ADMIN)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender_type' => $msg->sender_type,
                    'sender_name' => $msg->sender_name,
                    'message' => $msg->message,
                    'time' => $msg->created_at->format('H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'reference' => $conversation->reference,
            'status' => $conversation->status,
            'messages' => $messages,
        ]);
    }

    /**
     * Send a customer message in chat.
     */
    public function sendChatMessage(Request $request, string $reference): JsonResponse
    {
        $conversation = $this->authorizeConversationAccess($request, $reference);
        if (! $conversation) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy phiên hỗ trợ.'], 403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $senderName = auth()->user()?->name ?? 'Khách';

        $message = SupportMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => SupportMessage::SENDER_CUSTOMER,
            'sender_id' => auth()->id(),
            'sender_name' => $senderName,
            'message' => strip_tags(trim($validated['message'])),
        ]);

        $conversation->update([
            'last_message_at' => now(),
            'status' => ($conversation->status === SupportConversation::STATUS_CLOSED)
                ? SupportConversation::STATUS_OPEN
                : $conversation->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'sender_type' => $message->sender_type,
                'sender_name' => $message->sender_name,
                'message' => $message->message,
                'time' => $message->created_at->format('H:i'),
            ],
        ]);
    }

    /**
     * Check if current user or guest has access to this conversation.
     */
    protected function authorizeConversationAccess(Request $request, string $reference): ?SupportConversation
    {
        $conversation = SupportConversation::where('reference', $reference)->first();
        if (! $conversation) {
            return null;
        }

        if (auth()->check()) {
            if ($conversation->user_id === auth()->id()) {
                return $conversation;
            }
        }

        $guestToken = $request->session()->get('support_guest_token');
        if ($guestToken && $conversation->guest_token === $guestToken) {
            return $conversation;
        }

        return null;
    }
}
