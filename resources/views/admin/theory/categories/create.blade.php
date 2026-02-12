@extends('adminlte::page')

@section('title', 'Add Theory Category')

@section('content_header')
    <h1>Add Theory Test Category</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.theory.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group"><label>Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
            <div class="form-group"><label>Pass Percentage *</label><input type="number" name="pass_percentage" class="form-control" min="1" max="100" required value="{{ old('pass_percentage', 80) }}"></div>
            <div class="form-group"><label>Time Limit (minutes) *</label><input type="number" name="time_limit_minutes" class="form-control" min="5" max="120" required value="{{ old('time_limit_minutes', 30) }}"></div>
            <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Create</button><a href="{{ route('admin.theory.categories.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
