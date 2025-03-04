<?php

namespace App\Mail;

use App\Libraries\Email;
use App\Libraries\Users;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LowItemNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $users_lib;
    protected $email_lib;
    public $item;

    /**
     * Create a new message instance.
     */
    public function __construct(int $item_id)
    {
        $this->item = Item::find($item_id);
        $this->users_lib = new Users();
        $this->email_lib = new Email();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $admin_users = $this->users_lib->get_admin_users();
        $replyTo = $this->email_lib->get_recipients($admin_users);

        return new Envelope(
            new Address('support@rieves.com', 'Rieves Support'),
            $replyTo,
            subject: 'Low Item Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.items.LowItem'
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
