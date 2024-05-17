<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $this->view('erp.parts.emails.shipped');

        // return $this->view('erp.parts.emails.shipped');
        // ->text('erp.parts.emails.shipped_plain');
        // ->with([
        //     'executionDate' => $this->order->execution_date,
        //     'totalPrice'=> $this->order->total_price,

        // ]);
        // ->attach('/path/to/file');
        // ->attach('/path/to/file/', [
        //     'as' => 'name.pdf',
        //     'mine' => 'application/pdf',
        // ]);
        // ->attachFromStorage('/path/to/file');
        // ->attachFromStorage('/path/to/file/', [
        //     'as' => 'name.pdf',
        //     'mine' => 'application/pdf',
        // ]);

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader(
                'Custom-Header',
                'Header Value'
            );
        });
        return $this->markdown('erp.parts.emails.shipped',[
            'url'=>$this->order->id,

        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Shipped',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'erp.parts.emails.shipped',
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
