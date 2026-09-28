<?php

namespace App\Services;

use App\Mail\NewSupportRequestAdmin;
use App\Mail\SupportReplyMail;
use App\Mail\SupportRequestReceived;
use App\Mail\SupportResolvedMail;
use App\Models\ContactMessage;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SupportEmailService
{
    /**
     * Send confirmation email to customer upon receiving a contact message.
     */
    public function sendCustomerReceived(ContactMessage $contactMessage): bool
    {
        $recipient = $contactMessage->email;
        $type = 'contact_received';

        try {
            Mail::to($recipient)->send(new SupportRequestReceived($contactMessage));

            EmailLog::create([
                'type' => $type,
                'recipient' => $recipient,
                'related_type' => ContactMessage::class,
                'related_id' => $contactMessage->id,
                'status' => EmailLog::STATUS_SENT,
                'sent_at' => now(),
            ]);

            return true;
        } catch (Throwable $e) {
            $this->logFailure($type, $recipient, ContactMessage::class, $contactMessage->id, $e);

            return false;
        }
    }

    /**
     * Send notification email to admin about a new contact message.
     */
    public function sendAdminNewRequest(ContactMessage $contactMessage): bool
    {
        $adminEmail = config('mail.from.address', 'lunaraslivertrangsuc@gmail.com');
        $type = 'admin_new_request';

        try {
            Mail::to($adminEmail)->send(new NewSupportRequestAdmin($contactMessage));

            EmailLog::create([
                'type' => $type,
                'recipient' => $adminEmail,
                'related_type' => ContactMessage::class,
                'related_id' => $contactMessage->id,
                'status' => EmailLog::STATUS_SENT,
                'sent_at' => now(),
            ]);

            return true;
        } catch (Throwable $e) {
            $this->logFailure($type, $adminEmail, ContactMessage::class, $contactMessage->id, $e);

            return false;
        }
    }

    /**
     * Send reply email to customer from admin.
     */
    public function sendSupportReply(
        string $recipientEmail,
        string $customerName,
        string $reference,
        string $replyContent,
        ?string $originalSubject = null,
        ?string $actionUrl = null,
        ?string $relatedType = null,
        ?int $relatedId = null
    ): bool {
        $type = 'support_reply';

        try {
            Mail::to($recipientEmail)->send(new SupportReplyMail(
                reference: $reference,
                customerName: $customerName,
                replyContent: $replyContent,
                originalSubject: $originalSubject,
                actionUrl: $actionUrl,
            ));

            EmailLog::create([
                'type' => $type,
                'recipient' => $recipientEmail,
                'related_type' => $relatedType,
                'related_id' => $relatedId,
                'status' => EmailLog::STATUS_SENT,
                'sent_at' => now(),
            ]);

            return true;
        } catch (Throwable $e) {
            $this->logFailure($type, $recipientEmail, $relatedType, $relatedId, $e);

            return false;
        }
    }

    /**
     * Send resolution notification email to customer.
     */
    public function sendSupportResolved(ContactMessage $contactMessage, ?string $actionUrl = null): bool
    {
        $recipient = $contactMessage->email;
        $type = 'support_resolved';

        try {
            Mail::to($recipient)->send(new SupportResolvedMail($contactMessage, $actionUrl));

            EmailLog::create([
                'type' => $type,
                'recipient' => $recipient,
                'related_type' => ContactMessage::class,
                'related_id' => $contactMessage->id,
                'status' => EmailLog::STATUS_SENT,
                'sent_at' => now(),
            ]);

            return true;
        } catch (Throwable $e) {
            $this->logFailure($type, $recipient, ContactMessage::class, $contactMessage->id, $e);

            return false;
        }
    }

    /**
     * Log failure safely without leaking sensitive information.
     */
    protected function logFailure(string $type, string $recipient, ?string $relatedType, ?int $relatedId, Throwable $e): void
    {
        // Sanitize error message to prevent any credentials exposure
        $cleanError = preg_replace('/password=[^\s&]+/i', 'password=***', $e->getMessage());

        Log::warning('Support email delivery failed', [
            'type' => $type,
            'recipient_domain' => substr(strrchr($recipient, '@') ?: '', 1),
            'related_type' => $relatedType,
            'related_id' => $relatedId,
            'error' => $cleanError,
        ]);

        try {
            EmailLog::create([
                'type' => $type,
                'recipient' => $recipient,
                'related_type' => $relatedType,
                'related_id' => $relatedId,
                'status' => EmailLog::STATUS_FAILED,
                'error_message' => mb_substr($cleanError, 0, 500),
                'sent_at' => null,
            ]);
        } catch (Throwable $logDbEx) {
            // Silently capture DB log failure so nothing crashes
        }
    }
}
