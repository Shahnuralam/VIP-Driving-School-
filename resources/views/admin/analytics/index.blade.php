@extends('adminlte::page')

@section('title', 'Analytics')

@section('content_header')
    <h1>Analytics <small>Last {{ $period }} days</small></h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info"><div class="inner"><h3>{{ $totalBookings }}</h3><p>Total Bookings</p></div></div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success"><div class="inner"><h3>${{ number_format($totalRevenue, 0) }}</h3><p>Revenue</p></div></div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary"><div class="inner"><h3>{{ $completedBookings }}</h3><p>Completed</p></div></div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning"><div class="inner"><h3>{{ $newCustomers }}</h3><p>New Customers</p></div></div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card"><div class="card-header"><h5>Top Services</h5></div><div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse($topServices as $s)
                <li class="list-group-item d-flex justify-content-between"><span>{{ $s->service->name ?? 'N/A' }}</span><span>{{ $s->count }} bookings — ${{ number_format($s->revenue, 0) }}</span></li>
                @empty
                <li class="list-group-item text-muted">No data</li>
                @endforelse
            </ul>
        </div></div>
    </div>
    <div class="col-md-6">
        <div class="card"><div class="card-header"><h5>Top Packages</h5></div><div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse($topPackages as $p)
                <li class="list-group-item d-flex justify-content-between"><span>{{ $p->package->name ?? 'N/A' }}</span><span>{{ $p->count }} bookings — ${{ number_format($p->revenue, 0) }}</span></li>
                @empty
                <li class="list-group-item text-muted">No data</li>
                @endforelse
            </ul>
        </div></div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <div class="card"><div class="card-header"><h5>Top Locations</h5></div><div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse($topLocations as $l)
                <li class="list-group-item d-flex justify-content-between"><span>{{ $l->location->name ?? 'N/A' }}</span><span>{{ $l->count }} bookings</span></li>
                @empty
                <li class="list-group-item text-muted">No data</li>
                @endforelse
            </ul>
        </div></div>
    </div>
    <div class="col-md-6">
        <div class="card"><div class="card-header"><h5>Summary</h5></div><div class="card-body">
            <p><strong>Cancelled:</strong> {{ $cancelledBookings }}</p>
            <p><strong>Conversion (paid):</strong> {{ $conversionRate }}%</p>
        </div></div>
    </div>
</div>
@stop
