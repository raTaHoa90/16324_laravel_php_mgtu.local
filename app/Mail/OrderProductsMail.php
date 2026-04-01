<?php

namespace App\Mail;

use App\Models\OrderRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderProductsMail extends Mailable
{
    use Queueable, SerializesModels;

    public int $orderID;
    public OrderRecord $order;

    /**
     * Create a new message instance.
     */
    public function __construct(OrderRecord $order)
    {
        $this->orderID = $order->id;
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Заказ №'.$this->orderID.' оформлен '.$this->order->created_at->format('d.m.Y в H:i:s'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.add_order',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
