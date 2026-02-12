<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class AdminBookingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $notificationType;

    public function __construct(Booking $booking, string $notificationType = 'new')
    {
        $this->booking = $booking->load(['service', 'package', 'location']);
        $this->notificationType = $notificationType;
    }

    public function envelope(): Envelope
    {
        $subject = match($this->notificationType) {
            'new' => 'New Booking Received',
            'cancelled' => 'Booking Cancelled',
            default => 'Booking Update',
        };

        return new Envelope(
            from: new Address(
                config('mail.from.address'),
                config('mail.from.name', 'VIP Driving School')
            ),
            subject: "[{$this->booking->booking_reference}] {$subject}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-booking-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
