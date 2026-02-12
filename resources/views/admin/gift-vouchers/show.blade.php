@extends('adminlte::page')

@section('title', 'Gift Voucher ' . $giftVoucher->code)

@section('content_header')
    <h1>Gift Voucher: {{ $giftVoucher->code }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Type:</strong> {{ ucfirst($giftVoucher->type) }} &bull; <strong>Value:</strong> {{ $giftVoucher->getValueText() }} &bull; <strong>Balance:</strong> {{ $giftVoucher->getBalanceText() }}</p>
        <p><strong>Purchaser:</strong> {{ $giftVoucher->purchaser_name }} ({{ $giftVoucher->purchaser_email }})</p>
        <p><strong>Recipient:</strong> {{ $giftVoucher->recipient_name }} ({{ $giftVoucher->recipient_email }})</p>
        <p><strong>Status:</strong> <span class="badge badge-{{ $giftVoucher->getStatusBadgeClass() }}">{{ $giftVoucher->status }}</span> &bull; <strong>Payment:</strong> {{ $giftVoucher->payment_status }}</p>
        <p><strong>Expires:</strong> {{ $giftVoucher->expires_at->format('M j, Y') }}</p>
        @if($giftVoucher->redeemed_at)
        <p><strong>Redeemed:</strong> {{ $giftVoucher->redeemed_at->format('M j, Y H:i') }} @if($giftVoucher->redeemedBooking) — Booking {{ $giftVoucher->redeemedBooking->booking_reference }} @endif</p>
        @endif
        <a href="{{ route('admin.gift-vouchers.edit', $giftVoucher) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.gift-vouchers.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@stop
