@extends('adminlte::page')

@section('title', 'Cancellation Request')

@section('content_header')
    <h1>Cancellation Request</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Booking:</strong> {{ $cancellationRequest->booking->booking_reference }} — ${{ number_format($cancellationRequest->booking->amount, 2) }}</p>
        <p><strong>Reason:</strong> {{ $cancellationRequest->reason }}</p>
        <p><strong>Status:</strong> <span class="badge badge-{{ $cancellationRequest->getStatusBadgeClass() }}">{{ $cancellationRequest->status }}</span></p>
        @if($cancellationRequest->status === 'pending')
        <hr>
        <form action="{{ route('admin.cancellation-requests.process', $cancellationRequest) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Action</label>
                <select name="action" class="form-control" required>
                    <option value="approve_refund">Approve with Refund</option>
                    <option value="approve_no_refund">Approve without Refund</option>
                    <option value="reject">Reject</option>
                </select>
            </div>
            <div class="form-group">
                <label>Refund Amount (if partial)</label>
                <input type="number" name="refund_amount" class="form-control" step="0.01" min="0" value="{{ $cancellationRequest->booking->amount }}" placeholder="Full amount or leave for full refund">
            </div>
            <div class="form-group">
                <label>Admin Notes</label>
                <textarea name="admin_notes" class="form-control" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Process</button>
        </form>
        @endif
        <a href="{{ route('admin.cancellation-requests.index') }}" class="btn btn-secondary mt-2">Back</a>
    </div>
</div>
@stop
