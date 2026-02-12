@extends('adminlte::page')

@section('title', 'Edit Customer')

@section('content_header')
    <h1>Edit Customer: {{ $customer->name }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required></div>
            <div class="form-group"><label>Email</label><input type="email" class="form-control" value="{{ $customer->email }}" disabled></div>
            <div class="form-group"><label>Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}"></div>
            <div class="form-group"><label>Address</label><input type="text" name="address" class="form-control" value="{{ old('address', $customer->address) }}"></div>
            <div class="form-group"><label>Suburb</label><input type="text" name="suburb" class="form-control" value="{{ old('suburb', $customer->suburb) }}"></div>
            <div class="form-group"><label>Postcode</label><input type="text" name="postcode" class="form-control" value="{{ old('postcode', $customer->postcode) }}"></div>
            <div class="form-group"><label>License Number</label><input type="text" name="license_number" class="form-control" value="{{ old('license_number', $customer->license_number) }}"></div>
            <div class="form-group"><label>Preferred Transmission</label><select name="preferred_transmission" class="form-control"><option value="auto" {{ old('preferred_transmission', $customer->preferred_transmission) == 'auto' ? 'selected' : '' }}>Automatic</option><option value="manual" {{ old('preferred_transmission', $customer->preferred_transmission) == 'manual' ? 'selected' : '' }}>Manual</option></select></div>
            <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $customer->is_active) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
            <div class="form-group mt-3"><label>New Password (leave blank to keep)</label><input type="password" name="password" class="form-control" placeholder="New password"><input type="password" name="password_confirmation" class="form-control mt-1" placeholder="Confirm"></div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Update</button><a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
