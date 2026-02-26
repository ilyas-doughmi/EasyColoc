<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ColocationInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invitation $invitation,
        public string $colocationName
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rejoignez la colocation : ' . $this->colocationName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
