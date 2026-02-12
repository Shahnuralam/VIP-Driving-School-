@extends('adminlte::page')

@section('title', 'Gift Vouchers')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Gift Vouchers</h1>
        <a href="{{ route('admin.gift-vouchers.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Voucher</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Code</th><th>Type</th><th>Value/Balance</th><th>Purchaser</th><th>Recipient</th><th>Status</th><th>Expires</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($vouchers as $v)
                <tr>
                    <td><code>{{ $v->code }}</code></td>
                    <td>{{ ucfirst($v->type) }}</td>
                    <td>{{ $v->getValueText() }} @if($v->type === 'fixed') / {{ $v->getBalanceText() }} @endif</td>
                    <td>{{ $v->purchaser_email }}</td>
                    <td>{{ $v->recipient_email }}</td>
                    <td><span class="badge badge-{{ $v->getStatusBadgeClass() }}">{{ $v->status }}</span></td>
                    <td>{{ $v->expires_at->format('M j, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.gift-vouchers.show', $v) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.gift-vouchers.edit', $v) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">No gift vouchers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($vouchers->hasPages())
    <div class="card-footer">{{ $vouchers->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
