<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccessChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $name;
    public $type;
    public $changedAccess;
    /**
     * Create a new message instance.
     */
    public function __construct($email,$name, $type, $changedAccess)
    {
        $this->email = $email;
        $this->name = $name;
        $this->type = $type;
        $this->changedAccess = $changedAccess;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('test@test.com','Laravel test'),
            to: $this->email,
            subject: 'Access Changed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.access',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
