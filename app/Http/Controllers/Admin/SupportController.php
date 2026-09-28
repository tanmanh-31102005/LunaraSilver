<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use App\Models\User;
use App\Services\SupportEmailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupportController extends Controller
{
    /**
     * List all customer contact requests / support tickets.
     */
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->with(['user', 'order', 'assignedUser']);

        // Search
        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhereHas('order', function ($oq) use ($search) {
                        $oq->where('order_code', 'like', "%{$search}%");
                    });
            });
        }

        // Filters
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($assignedTo = $request->input('assigned_to')) {
            $query->where('assigned_to', $assignedTo);
        }

        if ($request->input('has_order') === '1') {
            $query->whereNotNull('order_id');
        } elseif ($request->input('has_order') === '0') {
            $query->whereNull('order_id');
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $messages = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        // Counter stats
        $stats = [
            'total' => ContactMessage::count(),
            'new' => ContactMessage::where('status', ContactMessage::STATUS_NEW)->count(),
            'in_progress' => ContactMessage::where('status', ContactMessage::STATUS_IN_PROGRESS)->count(),
            'resolved' => ContactMessage::where('status', ContactMessage::STATUS_RESOLVED)->count(),
            'closed' => ContactMessage::where('status', ContactMessage::STATUS_CLOSED)->count(),
        ];

        $unreadChatCount = SupportMessage::where('sender_type', SupportMessage::SENDER_CUSTOMER)
            ->whereNull('read_at')
            ->count();

        $admins = User::where('role', 'admin')->get(['id', 'name']);

        return view('admin.support.index', compact('messages', 'stats', 'unreadChatCount', 'admins'));
    }

    /**
     * Show contact message detail.
     */
    public function show(ContactMessage $support): View
    {
        $support->load(['user', 'order.items.product', 'assignedUser']);
        $admins = User::where('role', 'admin')->get(['id', 'name']);

        return view('admin.support.show', [
            'contact' => $support,
            'admins' => $admins,
        ]);
    }

    /**
     * Update status of contact message.
     */
    public function updateStatus(Request $request, ContactMessage $support, SupportEmailService $emailService): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:'.implode(',', ContactMessage::STATUSES),
        ]);

        $oldStatus = $support->status;
        $newStatus = $validated['status'];

        $support->update(['status' => $newStatus]);

        if ($newStatus === ContactMessage::STATUS_RESOLVED && $oldStatus !== ContactMessage::STATUS_RESOLVED) {
            $emailService->sendSupportResolved($support, url('/support'));
        }

        return back()->with('success', 'Trạng thái yêu cầu hỗ trợ đã được cập nhật thành: '.ContactMessage::STATUS_LABELS[$newStatus]);
    }

    /**
     * Assign message to admin.
     */
    public function assign(Request $request, ContactMessage $support): RedirectResponse
    {
        $validated = $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $adminId = $validated['assigned_to'] ?? auth()->id();

        $support->update([
            'assigned_to' => $adminId,
            'status' => ($support->status === ContactMessage::STATUS_NEW) ? ContactMessage::STATUS_IN_PROGRESS : $support->status,
        ]);

        return back()->with('success', 'Đã phân công chuyên viên xử lý yêu cầu thành công.');
    }

    /**
     * Save internal notes (not visible to customer).
     */
    public function saveNotes(Request $request, ContactMessage $support): RedirectResponse
    {
        $validated = $request->validate([
            'internal_notes' => 'nullable|string|max:5000',
        ]);

        $support->update([
            'internal_notes' => $validated['internal_notes'],
        ]);

        return back()->with('success', 'Đã lưu ghi chú nội bộ thành công.');
    }

    /**
     * Reply to customer via email.
     */
    public function reply(Request $request, ContactMessage $support, SupportEmailService $emailService): RedirectResponse
    {
        $validated = $request->validate([
            'reply_content' => 'required|string|min:5|max:5000',
        ], [
            'reply_content.required' => 'Vui lòng nhập nội dung phản hồi cho khách hàng.',
            'reply_content.min' => 'Nội dung phản hồi tối thiểu 5 ký tự.',
        ]);

        $sent = $emailService->sendSupportReply(
            recipientEmail: $support->email,
            customerName: $support->name,
            reference: $support->reference,
            replyContent: $validated['reply_content'],
            originalSubject: $support->subject,
            actionUrl: url('/support'),
            relatedType: ContactMessage::class,
            relatedId: $support->id,
        );

        // Append to internal note timestamped record of reply
        $timestamp = now()->format('H:i d/m/Y');
        $adminName = auth()->user()?->name ?? 'Admin';
        $logEntry = "\n\n[{$timestamp} - Phản hồi từ {$adminName}]:\n".$validated['reply_content'];
        $support->update([
            'internal_notes' => ($support->internal_notes ?? '').$logEntry,
            'status' => ($support->status === ContactMessage::STATUS_NEW) ? ContactMessage::STATUS_IN_PROGRESS : $support->status,
            'assigned_to' => $support->assigned_to ?? auth()->id(),
        ]);

        if ($sent) {
            return back()->with('success', 'Đã gửi phản hồi qua email tới khách hàng thành công.');
        }

        return back()->with('warning', 'Nội dung phản hồi đã được ghi nhận, tuy nhiên email gửi đi chưa thành công. Vui lòng kiểm tra lại cấu hình thư.');
    }

    /**
     * List all live chat conversations.
     */
    public function chatIndex(): View
    {
        $conversations = SupportConversation::query()
            ->with(['user', 'assignedUser'])
            ->withCount(['messages as unread_count' => function ($q) {
                $q->where('sender_type', SupportMessage::SENDER_CUSTOMER)->whereNull('read_at');
            }])
            ->orderByDesc('last_message_at')
            ->paginate(15);

        return view('admin.support.chat_index', compact('conversations'));
    }

    /**
     * Show live chat conversation details and reply interface.
     */
    public function chatShow(SupportConversation $conversation): View
    {
        $conversation->load(['user', 'assignedUser']);

        // Mark customer messages as read
        $conversation->messages()
            ->where('sender_type', SupportMessage::SENDER_CUSTOMER)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();

        return view('admin.support.chat_show', compact('conversation', 'messages'));
    }

    /**
     * Reply to a live chat conversation from Admin.
     */
    public function chatReply(Request $request, SupportConversation $conversation, SupportEmailService $emailService): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:3000',
            'send_email' => 'nullable|boolean',
        ]);

        $adminName = auth()->user()?->name ?? 'Chuyên viên Lunara';

        SupportMessage::create([
            'conversation_id' => $conversation->id,
            'sender_type' => SupportMessage::SENDER_ADMIN,
            'sender_id' => auth()->id(),
            'sender_name' => $adminName,
            'message' => strip_tags(trim($validated['message'])),
        ]);

        $conversation->update([
            'last_message_at' => now(),
            'assigned_to' => auth()->id(),
            'status' => SupportConversation::STATUS_ASSIGNED,
        ]);

        // Optional email copy if customer email is available
        $customerEmail = $conversation->customer_email ?? $conversation->user?->email;
        if (! empty($validated['send_email']) && $customerEmail) {
            $customerName = $conversation->customer_name ?? $conversation->user?->name ?? 'Quý khách';
            $emailService->sendSupportReply(
                recipientEmail: $customerEmail,
                customerName: $customerName,
                reference: $conversation->reference,
                replyContent: $validated['message'],
                originalSubject: 'Hỗ trợ trực tuyến Lunara Silver',
                actionUrl: url('/support'),
                relatedType: SupportConversation::class,
                relatedId: $conversation->id,
            );
        }

        return back()->with('success', 'Đã gửi tin nhắn phản hồi thành công.');
    }

    /**
     * Close a live chat conversation.
     */
    public function chatClose(SupportConversation $conversation): RedirectResponse
    {
        $conversation->update(['status' => SupportConversation::STATUS_CLOSED]);

        return back()->with('success', 'Phiên trò chuyện đã được đóng.');
    }
}
