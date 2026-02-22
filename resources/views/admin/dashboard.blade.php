@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <!-- Today's Bookings -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $todayBookings }}</h3>
                <p>Today's Appointments</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <a href="{{ route('admin.bookings.index', ['date_from' => date('Y-m-d'), 'date_to' => date('Y-m-d')]) }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Today's Revenue -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>${{ number_format($todayRevenue, 0) }}</h3>
                <p>Today's Revenue</p>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <a href="{{ route('admin.bookings.index', ['payment_status' => 'paid']) }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Pending Bookings -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pendingBookings }}</h3>
                <p>Pending Appointments</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('admin.bookings.pending') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- New Messages -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $newContacts }}</h3>
                <p>New Messages</p>
            </div>
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
            <a href="#" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Monthly Stats -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1"></i>
                    Monthly Revenue (Last 6 Months)
                </h3>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-1"></i>
                    Quick Stats
                </h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        This Week Appointments
                        <span class="badge badge-primary badge-pill">{{ $weekBookings }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        This Week Revenue
                        <span class="badge badge-success badge-pill">${{ number_format($weekRevenue, 0) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        This Month Appointments
                        <span class="badge badge-primary badge-pill">{{ $monthBookings }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        This Month Revenue
                        <span class="badge badge-success badge-pill">${{ number_format($monthRevenue, 0) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Active Services
                        <span class="badge badge-info badge-pill">{{ $totalServices }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Active Packages
                        <span class="badge badge-info badge-pill">{{ $totalPackages }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Active Locations
                        <span class="badge badge-info badge-pill">{{ $totalLocations }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Upcoming Bookings -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar mr-1"></i>
                    Upcoming Appointments
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingBookings as $booking)
                        <tr>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->service?->name ?? 'Package' }}</td>
                            <td>{{ $booking->booking_date->format('M j') }} {{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</td>
                            <td><span class="badge badge-{{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No upcoming appointments</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.bookings.index') }}">View All Appointments</a>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history mr-1"></i>
                    Recent Appointments
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                        <tr>
                            <td><a href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->booking_reference }}</a></td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->formatted_amount }}</td>
                            <td><span class="badge badge-{{ $booking->payment_badge }}">{{ ucfirst($booking->payment_status) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No recent appointments</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('admin.bookings.index') }}">View All Appointments</a>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Revenue ($)',
                data: @json($chartData['data']),
                backgroundColor: 'rgba(60, 141, 188, 0.7)',
                borderColor: 'rgba(60, 141, 188, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });
});
</script>
@stop
