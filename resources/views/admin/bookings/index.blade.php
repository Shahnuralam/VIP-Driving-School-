@extends('adminlte::page')

@section('title', 'Appointments')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Appointments</h1>
        <div>
            <a href="{{ route('admin.bookings.calendar') }}" class="btn btn-info">
                <i class="fas fa-calendar-alt"></i> Calendar View
            </a>
            <a href="{{ route('admin.bookings.export', request()->all()) }}" class="btn btn-success">
                <i class="fas fa-download"></i> Export CSV
            </a>
        </div>
    </div>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('warning') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="row">
            <div class="col-md-2">
                <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="payment_status" class="form-control">
                    <option value="">Payment Status</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-secondary">Filter</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
        <hr class="my-3">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <i class="fas fa-info-circle mr-1"></i>
                Bulk and single delete are available for cancelled appointments only.
            </small>
            <button type="submit"
                    form="bulkDeleteForm"
                    id="bulkDeleteBtn"
                    class="btn btn-danger btn-sm"
                    disabled
                    onclick="return confirm('Delete selected appointments permanently? This action cannot be undone.');">
                <i class="fas fa-trash mr-1"></i> Delete Selected (<span id="selectedCount">0</span>)
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <form id="bulkDeleteForm" action="{{ route('admin.bookings.bulk-destroy') }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th style="width: 40px;">
                        <input type="checkbox" id="selectAllBookings" title="Select all">
                    </th>
                    <th>Reference</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Date & Time</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>
                        <input type="checkbox"
                               name="booking_ids[]"
                               value="{{ $booking->id }}"
                               form="bulkDeleteForm"
                               class="booking-checkbox"
                               title="Select appointment {{ $booking->booking_reference }}">
                    </td>
                    <td><a href="{{ route('admin.bookings.show', $booking) }}">{{ $booking->booking_reference }}</a></td>
                    <td>
                        <strong>{{ $booking->customer_name }}</strong><br>
                        <small class="text-muted">{{ $booking->customer_email }}</small>
                    </td>
                    <td>{{ $booking->service?->name ?? 'Package Booking' }}</td>
                    <td>
                        {{ $booking->booking_date->format('M j, Y') }}<br>
                        <small>{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</small>
                    </td>
                    <td>{{ $booking->formatted_amount }}</td>
                    <td><span class="badge badge-{{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span></td>
                    <td><span class="badge badge-{{ $booking->payment_badge }}">{{ ucfirst($booking->payment_status) }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info mr-1" title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            @if($booking->status === 'cancelled')
                                <form action="{{ route('admin.bookings.destroy', $booking) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete appointment {{ $booking->booking_reference }} permanently?');"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Only cancelled appointments can be deleted">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">No appointments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $bookings->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAllBookings');
    const checkboxes = Array.from(document.querySelectorAll('.booking-checkbox'));
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedCount = document.getElementById('selectedCount');

    function refreshSelectionState() {
        const checked = checkboxes.filter(cb => cb.checked).length;
        bulkDeleteBtn.disabled = checked === 0;
        selectedCount.textContent = checked;

        if (checkboxes.length > 0) {
            selectAll.checked = checked === checkboxes.length;
            selectAll.indeterminate = checked > 0 && checked < checkboxes.length;
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => {
                cb.checked = selectAll.checked;
            });
            refreshSelectionState();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', refreshSelectionState);
    });

    refreshSelectionState();
});
</script>
@stop
