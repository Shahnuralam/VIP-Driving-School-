@extends('adminlte::page')

@section('title', 'Coupons')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Coupons / Discount Codes</h1>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Coupon</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Code</th><th>Name</th><th>Type</th><th>Value</th><th>Used</th><th>Valid</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($coupons as $c)
                <tr>
                    <td><code>{{ $c->code }}</code></td>
                    <td>{{ $c->name }}</td>
                    <td>{{ ucfirst($c->type) }}</td>
                    <td>{{ $c->getDiscountText() }}</td>
                    <td>{{ $c->times_used }}{!! $c->usage_limit ? ' / ' . $c->usage_limit : '' !!}</td>
                    <td>
                        @if($c->expires_at && $c->expires_at < now())
                        <span class="badge badge-danger">Expired</span>
                        @else
                        <span class="badge badge-{{ $c->is_active ? 'success' : 'secondary' }}">{{ $c->is_active ? 'Active' : 'Inactive' }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.coupons.show', $c) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.coupons.edit', $c) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">No coupons yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($coupons->hasPages())
    <div class="card-footer">{{ $coupons->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
