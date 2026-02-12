<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class BookingStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $previousStatus;

    public function __construct(Booking $booking, string $previousStatus)
    {
        $this->booking = $booking->load(['service', 'package', 'location']);
        $this->previousStatus = $previousStatus;
    }

    public function envelope(): Envelope
    {
        $subject = match($this->booking->status) {
            'confirmed' => 'Booking Confirmed',
            'completed' => 'Thank You for Your Lesson',
            'cancelled' => 'Booking Cancelled',
            default => 'Booking Update',
        };

        return new Envelope(
            from: new Address(
                config('mail.from.address'),
                config('mail.from.name', 'VIP Driving School')
            ),
            subject: $subject . ' - ' . $this->booking->booking_reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-status-update',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
