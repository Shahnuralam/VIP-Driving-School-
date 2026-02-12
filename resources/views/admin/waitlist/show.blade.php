@extends('adminlte::page')

@section('title', 'Waitlist Entry')

@section('content_header')
    <h1>Waitlist Entry</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Customer:</strong> {{ $waitlist->customer_name }} — {{ $waitlist->customer_email }} @if($waitlist->customer_phone) — {{ $waitlist->customer_phone }} @endif</p>
        <p><strong>Service/Package:</strong> {{ $waitlist->service->name ?? $waitlist->package->name ?? '-' }}</p>
        <p><strong>Location:</strong> {{ $waitlist->location->name ?? '-' }}</p>
        <p><strong>Preferred Date:</strong> {{ $waitlist->preferred_date->format('M j, Y') }} @if($waitlist->preferred_time) {{ \Carbon\Carbon::parse($waitlist->preferred_time)->format('g:i A') }} @endif</p>
        <p><strong>Status:</strong> <span class="badge badge-{{ $waitlist->getStatusBadgeClass() }}">{{ $waitlist->status }}</span></p>
        <form action="{{ route('admin.waitlist.update', $waitlist) }}" method="POST" class="form-inline">
            @csrf
            @method('PUT')
            <select name="status" class="form-control mr-2">
                @foreach(['waiting','notified','booked','expired','cancelled'] as $s)
                <option value="{{ $s }}" {{ $waitlist->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <a href="{{ route('admin.waitlist.index') }}" class="btn btn-secondary mt-2">Back</a>
    </div>
</div>
@stop
