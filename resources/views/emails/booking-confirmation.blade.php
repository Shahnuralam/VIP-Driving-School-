<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
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
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .success-icon {
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
            font-size: 24px;
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
        .amount-row {
            background: #f8f9fa;
        }
        .amount-row td {
            color: #28a745;
            font-size: 18px;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #1e3a5f;
            padding: 15px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        .info-box h3 {
            margin: 0 0 10px;
            color: #1e3a5f;
            font-size: 16px;
        }
        .info-box ul {
            margin: 0;
            padding-left: 20px;
        }
        .info-box li {
            margin-bottom: 5px;
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
        .footer a {
            color: #1e3a5f;
        }
        .social-links {
            margin: 15px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 5px;
            color: #666;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✓</div>
            <h1>Booking Confirmed!</h1>
            <p>Thank you for booking with VIP Driving School</p>
        </div>

        <div class="content">
            <p>Hi {{ $booking->customer_name }},</p>
            <p>Great news! Your booking has been confirmed and payment received. Here are your booking details:</p>

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
                    <td>{{ $booking->location->name }}<br><small>{{ $booking->location->address }}</small></td>
                </tr>
                @endif
                <tr>
                    <th>Transmission</th>
                    <td>{{ ucfirst($booking->transmission_type) }}</td>
                </tr>
                @if($booking->pickup_address)
                <tr>
                    <th>Pickup Address</th>
                    <td>{{ $booking->pickup_address }}</td>
                </tr>
                @endif
                <tr class="amount-row">
                    <th>Amount Paid</th>
                    <td>${{ number_format($booking->amount, 2) }}</td>
                </tr>
            </table>

            <div class="info-box">
                <h3>What to Bring</h3>
                <ul>
                    <li>Your valid Learner Licence</li>
                    <li>Glasses or contact lenses (if required for driving)</li>
                    <li>Comfortable clothing and flat shoes</li>
                </ul>
            </div>

            <div class="info-box" style="background: #fff3cd; border-color: #ffc107;">
                <h3>Important Reminders</h3>
                <ul>
                    <li>Please arrive 15 minutes before your scheduled time</li>
                    <li>Contact us at least 24 hours in advance if you need to reschedule</li>
                    <li>Late cancellations may incur a fee</li>
                </ul>
            </div>

            <p>If you have any questions or need to make changes to your booking, please contact us.</p>

            <p style="text-align: center;">
                <a href="tel:0400000000" class="btn">Contact Us</a>
            </p>
        </div>

        <div class="footer">
            <div class="social-links">
                <a href="#">Facebook</a> |
                <a href="#">Instagram</a> |
                <a href="#">Google</a>
            </div>
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
