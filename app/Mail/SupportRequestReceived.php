<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lunara đã nhận yêu cầu hỗ trợ của bạn ['.$this->contactMessage->reference.']',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.support.customer-received',
        );
    }
}
