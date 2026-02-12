<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Notification</title>
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
            padding: 25px;
            text-align: center;
            color: white;
        }
        .header.new {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .header.cancelled {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .content {
            padding: 25px;
        }
        .booking-ref {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
        .booking-ref strong {
            font-size: 18px;
            color: #1e3a5f;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .details-table th,
        .details-table td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .details-table th {
            width: 35%;
            color: #666;
            font-weight: normal;
            background: #f8f9fa;
        }
        .details-table td {
            font-weight: 600;
        }
        .highlight-row {
            background: #e7f3ff;
        }
        .btn {
            display: inline-block;
            background: #1e3a5f;
            color: white;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 14px;
        }
        .footer {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .label {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        .label-success { background: #d4edda; color: #155724; }
        .label-warning { background: #fff3cd; color: #856404; }
        .label-danger { background: #f8d7da; color: #721c24; }
        .label-info { background: #d1ecf1; color: #0c5460; }
    </style>
</head>
<body>
    <div class="container">
        @if($notificationType === 'new')
        <div class="header new">
            <h1>🎉 New Booking Received</h1>
        </div>
        @elseif($notificationType === 'cancelled')
        <div class="header cancelled">
            <h1>❌ Booking Cancelled</h1>
        </div>
        @else
        <div class="header" style="background: #6c757d;">
            <h1>📋 Booking Update</h1>
        </div>
        @endif

        <div class="content">
            <div class="booking-ref">
                <p style="margin: 0 0 5px; color: #666; font-size: 13px;">Booking Reference</p>
                <strong>{{ $booking->booking_reference }}</strong>
            </div>

            <h3 style="margin-top: 0; color: #1e3a5f; border-bottom: 2px solid #1e3a5f; padding-bottom: 8px;">
                Customer Details
            </h3>
            <table class="details-table">
                <tr>
                    <th>Name</th>
                    <td>{{ $booking->customer_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><a href="mailto:{{ $booking->customer_email }}">{{ $booking->customer_email }}</a></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><a href="tel:{{ $booking->customer_phone }}">{{ $booking->customer_phone }}</a></td>
                </tr>
                @if($booking->customer_license)
                <tr>
                    <th>Licence #</th>
                    <td>{{ $booking->customer_license }}</td>
                </tr>
                @endif
                @if($booking->pickup_address)
                <tr>
                    <th>Pickup Address</th>
                    <td>{{ $booking->pickup_address }}</td>
                </tr>
                @endif
            </table>

            <h3 style="color: #1e3a5f; border-bottom: 2px solid #1e3a5f; padding-bottom: 8px;">
                Booking Details
            </h3>
            <table class="details-table">
                <tr>
                    <th>Service</th>
                    <td>
                        @if($booking->service)
                            {{ $booking->service->name }}
                        @elseif($booking->package)
                            {{ $booking->package->name }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr class="highlight-row">
                    <th>Date & Time</th>
                    <td>
                        <strong>{{ $booking->booking_date->format('l, M j, Y') }}</strong><br>
                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}
                    </td>
                </tr>
                @if($booking->location)
                <tr>
                    <th>Location</th>
                    <td>{{ $booking->location->name }}</td>
                </tr>
                @endif
                <tr>
                    <th>Transmission</th>
                    <td>{{ ucfirst($booking->transmission_type) }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @switch($booking->status)
                            @case('pending')
                                <span class="label label-warning">Pending</span>
                                @break
                            @case('confirmed')
                                <span class="label label-info">Confirmed</span>
                                @break
                            @case('completed')
                                <span class="label label-success">Completed</span>
                                @break
                            @case('cancelled')
                                <span class="label label-danger">Cancelled</span>
                                @break
                            @default
                                <span class="label">{{ ucfirst($booking->status) }}</span>
                        @endswitch
                    </td>
                </tr>
            </table>

            <h3 style="color: #1e3a5f; border-bottom: 2px solid #1e3a5f; padding-bottom: 8px;">
                Payment
            </h3>
            <table class="details-table">
                <tr>
                    <th>Amount</th>
                    <td><strong style="color: #28a745;">${{ number_format($booking->amount, 2) }}</strong></td>
                </tr>
                <tr>
                    <th>Payment Status</th>
                    <td>
                        @if($booking->payment_status === 'paid')
                            <span class="label label-success">Paid</span>
                        @elseif($booking->payment_status === 'pending')
                            <span class="label label-warning">Pending</span>
                        @elseif($booking->payment_status === 'refunded')
                            <span class="label label-info">Refunded</span>
                        @else
                            <span class="label label-danger">{{ ucfirst($booking->payment_status) }}</span>
                        @endif
                    </td>
                </tr>
                @if($booking->stripe_payment_intent_id)
                <tr>
                    <th>Stripe ID</th>
                    <td style="font-size: 11px;">{{ $booking->stripe_payment_intent_id }}</td>
                </tr>
                @endif
            </table>

            @if($booking->notes)
            <h3 style="color: #1e3a5f; border-bottom: 2px solid #1e3a5f; padding-bottom: 8px;">
                Customer Notes
            </h3>
            <div style="background: #fff3cd; padding: 15px; border-radius: 8px; font-size: 14px;">
                {{ $booking->notes }}
            </div>
            @endif

            @if($notificationType === 'cancelled' && $booking->cancellation_reason)
            <h3 style="color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 8px;">
                Cancellation Reason
            </h3>
            <div style="background: #f8d7da; padding: 15px; border-radius: 8px; font-size: 14px;">
                {{ $booking->cancellation_reason }}
            </div>
            @endif

            <p style="text-align: center; margin-top: 25px;">
                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn">View in Admin Panel</a>
            </p>
        </div>

        <div class="footer">
            <p>This is an automated notification from VIP Driving School booking system.</p>
            <p>{{ now()->format('F j, Y g:i A') }}</p>
        </div>
    </div>
</body>
</html>
