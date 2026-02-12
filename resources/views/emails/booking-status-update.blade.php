<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Update</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            padding: 30px;
            text-align: center;
            color: white;
        }
        .header.confirmed {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .header.completed {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8c 100%);
        }
        .header.cancelled {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .status-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        .content {
            padding: 30px;
        }
        .booking-ref {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 25px;
        }
        .booking-ref strong {
            font-size: 20px;
            color: #1e3a5f;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .details-table th,
        .details-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .details-table th {
            width: 40%;
            color: #666;
            font-weight: normal;
        }
        .details-table td {
            font-weight: 600;
        }
        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-info {
            background: #e7f3ff;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        .btn {
            display: inline-block;
            background: #ff6b35;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            margin-top: 10px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        @if($booking->status === 'confirmed')
        <div class="header confirmed">
            <div class="status-icon">✓</div>
            <h1>Booking Confirmed</h1>
        </div>
        @elseif($booking->status === 'completed')
        <div class="header completed">
            <div class="status-icon">★</div>
            <h1>Thank You!</h1>
        </div>
        @elseif($booking->status === 'cancelled')
        <div class="header cancelled">
            <div class="status-icon">✕</div>
            <h1>Booking Cancelled</h1>
        </div>
        @else
        <div class="header" style="background: #6c757d;">
            <div class="status-icon">!</div>
            <h1>Booking Update</h1>
        </div>
        @endif

        <div class="content">
            <p>Hi {{ $booking->customer_name }},</p>

            @if($booking->status === 'confirmed')
                <p>Your booking has been confirmed by our team. We look forward to seeing you!</p>

                <div class="alert-box alert-success">
                    <strong>What's Next?</strong><br>
                    Our instructor will contact you before your lesson to confirm pickup details.
                </div>

            @elseif($booking->status === 'completed')
                <p>Thank you for completing your driving lesson with VIP Driving School!</p>

                <div class="alert-box alert-info">
                    <strong>How Did We Do?</strong><br>
                    We'd love to hear your feedback! Please leave us a review on Google or Facebook.
                </div>

                <p>Ready to book your next lesson? Visit our website or call us to schedule.</p>

            @elseif($booking->status === 'cancelled')
                <p>Your booking has been cancelled.</p>

                @if($booking->cancellation_reason)
                    <div class="alert-box alert-warning">
                        <strong>Cancellation Reason:</strong><br>
                        {{ $booking->cancellation_reason }}
                    </div>
                @endif

                @if($booking->payment_status === 'refunded')
                    <div class="alert-box alert-info">
                        <strong>Refund Information:</strong><br>
                        Your payment has been refunded. Please allow 5-10 business days for the refund to appear in your account.
                    </div>
                @endif

                <p>We're sorry to see you go. If you'd like to reschedule, please contact us or book online.</p>
            @else
                <p>Your booking status has been updated to: <strong>{{ ucfirst($booking->status) }}</strong></p>
            @endif

            <div class="booking-ref">
                <p style="margin: 0 0 5px; color: #666;">Booking Reference</p>
                <strong>{{ $booking->booking_reference }}</strong>
            </div>

            <table class="details-table">
                <tr>
                    <th>Service</th>
                    <td>
                        @if($booking->service)
                            {{ $booking->service->name }}
                        @elseif($booking->package)
                            {{ $booking->package->name }}
                        @else
                            Driving Lesson
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $booking->booking_date->format('l, F j, Y') }}</td>
                </tr>
                <tr>
                    <th>Time</th>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</td>
                </tr>
                @if($booking->location)
                <tr>
                    <th>Location</th>
                    <td>{{ $booking->location->name }}</td>
                </tr>
                @endif
            </table>

            <p>If you have any questions, please don't hesitate to contact us.</p>

            <p style="text-align: center;">
                <a href="tel:0400000000" class="btn">Contact Us</a>
            </p>
        </div>

        <div class="footer">
            <p>
                <strong>VIP Driving School Hobart</strong><br>
                Phone: 0400 000 000<br>
                Email: info@vipdrivingschool.com.au
            </p>
            <p style="font-size: 12px; color: #999;">
                © {{ date('Y') }} VIP Driving School Hobart. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
