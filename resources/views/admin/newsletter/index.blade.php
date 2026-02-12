@extends('adminlte::page')

@section('title', 'Newsletter')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Newsletter Subscribers</h1>
        <a href="{{ route('admin.newsletter.export') }}" class="btn btn-success"><i class="fas fa-download"></i> Export CSV</a>
    </div>
@stop

@section('content')
<div class="row mb-3">
    <div class="col-md-4"><div class="small-box bg-info"><div class="inner"><h3>{{ $stats['total'] }}</h3><p>Total</p></div></div></div>
    <div class="col-md-4"><div class="small-box bg-success"><div class="inner"><h3>{{ $stats['subscribed'] }}</h3><p>Subscribed</p></div></div></div>
    <div class="col-md-4"><div class="small-box bg-warning"><div class="inner"><h3>{{ $stats['pending'] }}</h3><p>Pending</p></div></div></div>
</div>
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Email</th><th>Name</th><th>Status</th><th>Subscribed</th></tr>
            </thead>
            <tbody>
                @forelse($subscribers as $s)
                <tr>
                    <td>{{ $s->email }}</td>
                    <td>{{ $s->name ?? '-' }}</td>
                    <td><span class="badge badge-{{ $s->getStatusBadgeClass() }}">{{ $s->status }}</span></td>
                    <td>{{ $s->created_at->format('M j, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">No subscribers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($subscribers->hasPages())
    <div class="card-footer">{{ $subscribers->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
