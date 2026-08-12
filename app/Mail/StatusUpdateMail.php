<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $subjectTitle;
    public string $emailMessage;
    public ?string $actionUrl;

    public function __construct(User $user, string $subjectTitle, string $emailMessage, ?string $actionUrl = null)
    {
        $this->user = $user;
        $this->subjectTitle = $subjectTitle;
        $this->emailMessage = $emailMessage;
        $this->actionUrl = $actionUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[HKI UM BIMA] ' . $this->subjectTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.status_update',
            with: [
                'user' => $this->user,
                'subjectTitle' => $this->subjectTitle,
                'emailMessage' => $this->emailMessage,
                'actionUrl' => $this->actionUrl,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
