@extends('adminlte::page')

@section('title', 'Add Blog Category')

@section('content_header')
    <h1>Add Blog Category</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.blog.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group"><label>Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
            <div class="form-group"><label>Slug</label><input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Auto from name"></div>
            <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea></div>
            <div class="form-group"><label>Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}"></div>
            <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Create</button><a href="{{ route('admin.blog.categories.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
