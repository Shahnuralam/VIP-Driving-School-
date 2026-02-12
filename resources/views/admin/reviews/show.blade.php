@extends('adminlte::page')

@section('title', 'Review')

@section('content_header')
    <h1>Review by {{ $review->customer_name }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Rating:</strong> {{ $review->overall_rating }}/5 @if($review->instructor_rating) | Instructor: {{ $review->instructor_rating }}/5 @endif</p>
        @if($review->title)<p><strong>Title:</strong> {{ $review->title }}</p>@endif
        <p>{{ $review->content }}</p>
        <p class="text-muted small">Booking: {{ $review->booking->booking_reference ?? '-' }} | {{ $review->created_at->format('M j, Y H:i') }}</p>
        <p><span class="badge badge-{{ $review->getStatusBadgeClass() }}">{{ $review->status }}</span></p>
        @if($review->status === 'pending')
        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-success">Approve</button></form>
        <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline">@csrf
            <input type="text" name="rejection_reason" placeholder="Reason (optional)" class="form-control d-inline-block w-auto">
            <button type="submit" class="btn btn-danger">Reject</button>
        </form>
        @endif
        @if($review->status === 'approved' && !$review->admin_response)
        <form action="{{ route('admin.reviews.respond', $review) }}" method="POST" class="mt-3">
            @csrf
            <textarea name="admin_response" class="form-control" rows="3" placeholder="Add a response..."></textarea>
            <button type="submit" class="btn btn-primary mt-2">Add Response</button>
        </form>
        @endif
        @if($review->admin_response)
        <div class="alert alert-light border mt-3"><strong>Your response:</strong><br>{{ $review->admin_response }}</div>
        @endif
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary mt-2">Back to List</a>
    </div>
</div>
@stop
