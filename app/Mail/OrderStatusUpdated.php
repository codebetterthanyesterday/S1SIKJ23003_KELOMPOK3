<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $statusMessage;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param string $statusMessage
     * @return void
     */
    public function __construct(Order $order, $statusMessage)
    {
        $this->order = $order;
        $this->statusMessage = $statusMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Langsung-PO: Order #' . $this->order->id_order . ' Status Updated')
            ->markdown('emails.order-status-updated');
    }
}
