@extends('adminlte::page')

@section('title', 'Customer - ' . $customer->name)

@section('content_header')
    <h1>{{ $customer->name }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Email:</strong> {{ $customer->email }} &bull; <strong>Phone:</strong> {{ $customer->phone ?? '-' }}</p>
        <p><strong>Address:</strong> {{ $customer->address ?? '-' }} {{ $customer->suburb ?? '' }} {{ $customer->postcode ?? '' }}</p>
        <p><strong>Total Bookings:</strong> {{ $customer->bookings_count }} &bull; <strong>Status:</strong> <span class="badge badge-{{ $customer->is_active ? 'success' : 'secondary' }}">{{ $customer->is_active ? 'Active' : 'Inactive' }}</span></p>
        <h6>Recent Bookings</h6>
        <ul class="list-unstyled">
            @foreach($bookings as $b)
            <li><a href="{{ route('admin.bookings.show', $b) }}">{{ $b->booking_reference }}</a> — {{ $b->booking_date->format('M j, Y') }} — {{ $b->service->name ?? $b->package->name ?? 'Lesson' }}</li>
            @endforeach
        </ul>
        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@stop
