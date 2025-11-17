<?php

namespace App\Mail;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SoundNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $instance;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Notification $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Thông báo sự cố',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.sound-notification',
            with: [
                'title'       => $this->instance['title'],
                'messageContent' => $this->instance['message'],
                'location'    => $this->instance['location'],
                'sender_id'   => $this->instance['sender_id'] ?? null,
                'status'      => $this->instance['status'] ?? null,
                'contact_type' => $this->instance['contact_type'] ?? null,
                'type'        => $this->instance['type'] ?? null,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
