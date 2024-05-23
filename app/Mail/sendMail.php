<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $orderDate;
    public $element;
    public $orderNumber;
    public $cart;
    public $DETACheckout;

    /**
     * Create a new message instance.
     */
    public function __construct(
        $orderDate,
        $element,
        $orderNumber,
        $cart,
        $DETACheckout
    ) {
        $this->orderDate = $orderDate;
        $this->element = $element;
        $this->orderNumber = $orderNumber;
        $this->cart = $cart;
        $this->DETACheckout = $DETACheckout;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Thank you for orders!';
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {

        return new Content(
            view: 'auth.mail',
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
