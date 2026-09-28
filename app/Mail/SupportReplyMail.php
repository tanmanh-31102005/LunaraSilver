<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $reference,
        public string $customerName,
        public string $replyContent,
        public ?string $originalSubject = null,
        public ?string $actionUrl = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lunara đã phản hồi yêu cầu hỗ trợ của bạn ['.$this->reference.']',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.support.reply',
        );
    }
}
