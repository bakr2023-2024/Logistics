<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShipmentDeliveredEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $customer;
    public $shipment;

    /**
     * Create a new message instance.
     */
    public function __construct(Customer $customer, Shipment $shipment)
    {
        $this->customer = $customer;
        $this->shipment = $shipment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Shipment Has Been Delivered!');
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.shipment.delivered', // the Blade view to render the email content
            with: [
                'customer' => $this->customer,
                'shipment' => $this->shipment,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
