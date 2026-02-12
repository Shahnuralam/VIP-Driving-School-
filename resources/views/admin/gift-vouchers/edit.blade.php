@extends('adminlte::page')

@section('title', 'Edit Gift Voucher')

@section('content_header')
    <h1>Edit Gift Voucher: {{ $giftVoucher->code }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.gift-vouchers.update', $giftVoucher) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            @foreach(['active','partially_used','fully_used','expired','cancelled'] as $s)
                            <option value="{{ $s }}" {{ old('status', $giftVoucher->status) == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Payment Status</label>
                        <select name="payment_status" class="form-control">
                            @foreach(['pending','paid','refunded','failed'] as $s)
                            <option value="{{ $s }}" {{ old('payment_status', $giftVoucher->payment_status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Expires At</label>
                        <input type="date" name="expires_at" class="form-control" required value="{{ old('expires_at', $giftVoucher->expires_at->format('Y-m-d')) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Purchaser Name *</label>
                        <input type="text" name="purchaser_name" class="form-control" required value="{{ old('purchaser_name', $giftVoucher->purchaser_name) }}">
                    </div>
                    <div class="form-group">
                        <label>Purchaser Email *</label>
                        <input type="email" name="purchaser_email" class="form-control" required value="{{ old('purchaser_email', $giftVoucher->purchaser_email) }}">
                    </div>
                    <div class="form-group">
                        <label>Recipient Name *</label>
                        <input type="text" name="recipient_name" class="form-control" required value="{{ old('recipient_name', $giftVoucher->recipient_name) }}">
                    </div>
                    <div class="form-group">
                        <label>Recipient Email *</label>
                        <input type="email" name="recipient_email" class="form-control" required value="{{ old('recipient_email', $giftVoucher->recipient_email) }}">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" class="form-control" rows="2">{{ old('message', $giftVoucher->message) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.gift-vouchers.show', $giftVoucher) }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
@stop
