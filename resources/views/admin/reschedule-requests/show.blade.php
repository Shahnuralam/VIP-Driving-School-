@extends('adminlte::page')

@section('title', 'Reschedule Request')

@section('content_header')
    <h1>Reschedule Request</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Booking:</strong> {{ $rescheduleRequest->booking->booking_reference }}</p>
        <p><strong>Original:</strong> {{ $rescheduleRequest->original_date->format('l, M j, Y') }} at {{ \Carbon\Carbon::parse($rescheduleRequest->original_time)->format('g:i A') }}</p>
        <p><strong>Requested:</strong> {{ $rescheduleRequest->requested_date->format('l, M j, Y') }} @if($rescheduleRequest->newSlot) — Slot: {{ \Carbon\Carbon::parse($rescheduleRequest->newSlot->start_time)->format('g:i A') }} @endif</p>
        @if($rescheduleRequest->reason)<p><strong>Reason:</strong> {{ $rescheduleRequest->reason }}</p>@endif
        <p><strong>Status:</strong> <span class="badge badge-{{ $rescheduleRequest->getStatusBadgeClass() }}">{{ $rescheduleRequest->status }}</span></p>
        @if($rescheduleRequest->status === 'pending')
        <form action="{{ route('admin.reschedule-requests.approve', $rescheduleRequest) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-success">Approve</button></form>
        <form action="{{ route('admin.reschedule-requests.reject', $rescheduleRequest) }}" method="POST" class="d-inline">@csrf<input type="text" name="admin_notes" placeholder="Notes"> <button type="submit" class="btn btn-danger">Reject</button></form>
        @endif
        <a href="{{ route('admin.reschedule-requests.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@stop
