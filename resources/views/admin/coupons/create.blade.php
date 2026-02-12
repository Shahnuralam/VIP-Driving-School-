@extends('adminlte::page')

@section('title', 'Create Coupon')

@section('content_header')
    <h1>Create Coupon</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Code *</label>
                        <input type="text" name="code" class="form-control" required value="{{ old('code') }}" placeholder="e.g. SAVE10">
                    </div>
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label>Type *</label>
                        <select name="type" class="form-control" required>
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Value *</label>
                        <input type="number" name="value" class="form-control" step="0.01" min="0" required value="{{ old('value') }}" placeholder="e.g. 10 for 10% or 20 for $20">
                    </div>
                    <div class="form-group">
                        <label>Min Order Amount</label>
                        <input type="number" name="min_order_amount" class="form-control" step="0.01" min="0" value="{{ old('min_order_amount') }}">
                    </div>
                    <div class="form-group">
                        <label>Usage Limit (total)</label>
                        <input type="number" name="usage_limit" class="form-control" min="1" value="{{ old('usage_limit') }}" placeholder="Leave empty for unlimited">
                    </div>
                    <div class="form-group">
                        <label>Usage Limit Per Customer *</label>
                        <input type="number" name="usage_limit_per_customer" class="form-control" min="1" required value="{{ old('usage_limit_per_customer', 1) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Starts At</label>
                        <input type="datetime-local" name="starts_at" class="form-control" value="{{ old('starts_at') }}">
                    </div>
                    <div class="form-group">
                        <label>Expires At</label>
                        <input type="datetime-local" name="expires_at" class="form-control" value="{{ old('expires_at') }}">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="first_booking_only" value="1" class="form-check-input" {{ old('first_booking_only') ? 'checked' : '' }}>
                        <label class="form-check-label">First booking only</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create Coupon</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop
