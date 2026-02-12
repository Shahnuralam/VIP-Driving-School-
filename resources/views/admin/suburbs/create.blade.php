@extends('adminlte::page')

@section('title', 'Add Suburb')

@section('content_header')
    <h1>Add Service Area / Suburb</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.suburbs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group"><label>Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
            <div class="form-group"><label>Postcode</label><input type="text" name="postcode" class="form-control" value="{{ old('postcode') }}"></div>
            <div class="form-group"><label>State</label><input type="text" name="state" class="form-control" value="{{ old('state', 'TAS') }}"></div>
            <div class="form-group"><label>Latitude</label><input type="number" name="latitude" class="form-control" step="any" value="{{ old('latitude') }}"></div>
            <div class="form-group"><label>Longitude</label><input type="number" name="longitude" class="form-control" step="any" value="{{ old('longitude') }}"></div>
            <div class="form-group"><label>Content (SEO page)</label><textarea name="content" class="form-control" rows="5">{{ old('content') }}</textarea></div>
            <div class="form-check"><input type="checkbox" name="is_serviced" value="1" class="form-check-input" {{ old('is_serviced', true) ? 'checked' : '' }}><label class="form-check-label">Serviced</label></div>
            <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Create</button><a href="{{ route('admin.suburbs.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
