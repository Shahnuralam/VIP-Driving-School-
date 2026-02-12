@extends('adminlte::page')

@section('title', 'Edit Coupon')

@section('content_header')
    <h1>Edit Coupon: {{ $coupon->code }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group"><label>Code *</label><input type="text" name="code" class="form-control" required value="{{ old('code', $coupon->code) }}"></div>
            <div class="form-group"><label>Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name', $coupon->name) }}"></div>
            <div class="form-group"><label>Type *</label><select name="type" class="form-control" required><option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage</option><option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed</option></select></div>
            <div class="form-group"><label>Value *</label><input type="number" name="value" class="form-control" step="0.01" required value="{{ old('value', $coupon->value) }}"></div>
            <div class="form-group"><label>Usage Limit Per Customer *</label><input type="number" name="usage_limit_per_customer" class="form-control" min="1" required value="{{ old('usage_limit_per_customer', $coupon->usage_limit_per_customer) }}"></div>
            <div class="form-group"><label>Expires At</label><input type="datetime-local" name="expires_at" class="form-control" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d\TH:i')) }}"></div>
            <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Update</button><a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
