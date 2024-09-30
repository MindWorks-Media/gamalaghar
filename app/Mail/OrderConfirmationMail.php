<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $order;
    public $products;
    public $totalPrice;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $order, $products, $totalPrice)
    {
        $this->user = $user;
        $this->order = $order;
        $this->products = $products;
        $this->totalPrice = $totalPrice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->markdown('mail.order-confirmation-mail')->with([
            'user' => $this->user,
            'orderNumber' => $this->order->order_number,
            'products' => $this->products,  // Array of products with name, quantity, and price
            'totalPrice' => $this->totalPrice
        ]);
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
