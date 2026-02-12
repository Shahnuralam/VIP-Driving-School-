@extends('adminlte::page')

@section('title', 'Coupon ' . $coupon->code)

@section('content_header')
    <h1>Coupon: {{ $coupon->code }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Name:</strong> {{ $coupon->name }} &bull; <strong>Type:</strong> {{ $coupon->type }} &bull; <strong>Value:</strong> {{ $coupon->getDiscountText() }}</p>
        <p><strong>Times Used:</strong> {{ $coupon->times_used }}{!! $coupon->usage_limit ? ' / ' . $coupon->usage_limit : '' !!} &bull; <strong>Status:</strong> {{ $coupon->is_active ? 'Active' : 'Inactive' }}</p>
        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@stop
