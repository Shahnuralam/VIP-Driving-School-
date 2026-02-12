@extends('adminlte::page')

@section('title', 'Create Gift Voucher')

@section('content_header')
    <h1>Create Gift Voucher</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.gift-vouchers.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control" required>
                            <option value="fixed">Fixed Amount</option>
                            <option value="package">Package</option>
                        </select>
                    </div>
                    <div class="form-group" id="amount-group">
                        <label>Amount ($)</label>
                        <input type="number" name="amount" class="form-control" step="0.01" min="1" value="{{ old('amount') }}">
                    </div>
                    <div class="form-group" id="package-group" style="display:none;">
                        <label>Package</label>
                        <select name="package_id" class="form-control">
                            <option value="">Select package</option>
                            @foreach($packages as $p)
                            <option value="{{ $p->id }}" {{ old('package_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} - ${{ number_format($p->price, 2) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Expires At</label>
                        <input type="date" name="expires_at" class="form-control" required value="{{ old('expires_at') }}">
                    </div>
                    <div class="form-group">
                        <label>Payment Status</label>
                        <select name="payment_status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Purchaser Name *</label>
                        <input type="text" name="purchaser_name" class="form-control" required value="{{ old('purchaser_name') }}">
                    </div>
                    <div class="form-group">
                        <label>Purchaser Email *</label>
                        <input type="email" name="purchaser_email" class="form-control" required value="{{ old('purchaser_email') }}">
                    </div>
                    <div class="form-group">
                        <label>Purchaser Phone</label>
                        <input type="text" name="purchaser_phone" class="form-control" value="{{ old('purchaser_phone') }}">
                    </div>
                    <div class="form-group">
                        <label>Recipient Name *</label>
                        <input type="text" name="recipient_name" class="form-control" required value="{{ old('recipient_name') }}">
                    </div>
                    <div class="form-group">
                        <label>Recipient Email *</label>
                        <input type="email" name="recipient_email" class="form-control" required value="{{ old('recipient_email') }}">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" class="form-control" rows="2">{{ old('message') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create Voucher</button>
            <a href="{{ route('admin.gift-vouchers.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@push('js')
<script>
document.querySelector('select[name=type]').addEventListener('change', function() {
    var isFixed = this.value === 'fixed';
    document.getElementById('amount-group').style.display = isFixed ? 'block' : 'none';
    document.getElementById('package-group').style.display = isFixed ? 'none' : 'block';
});
document.querySelector('select[name=type]').dispatchEvent(new Event('change'));
</script>
@endpush
@stop
