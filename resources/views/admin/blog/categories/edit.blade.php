@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')
    <h1>Edit: {{ $blogCategory->name }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.blog.categories.update', $blogCategory) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group"><label>Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name', $blogCategory->name) }}"></div>
            <div class="form-group"><label>Slug</label><input type="text" name="slug" class="form-control" value="{{ old('slug', $blogCategory->slug) }}"></div>
            <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="2">{{ old('description', $blogCategory->description) }}</textarea></div>
            <div class="form-group"><label>Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $blogCategory->sort_order) }}"></div>
            <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $blogCategory->is_active) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Update</button><a href="{{ route('admin.blog.categories.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
