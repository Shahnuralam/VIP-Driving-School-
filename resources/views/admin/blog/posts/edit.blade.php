@extends('adminlte::page')

@section('title', 'Edit Post')

@section('content_header')
    <h1>Edit: {{ $post->title }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.blog.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group"><label>Title *</label><input type="text" name="title" class="form-control" required value="{{ old('title', $post->title) }}"></div>
            <div class="form-group"><label>Category</label><select name="blog_category_id" class="form-control"><option value="">None</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ old('blog_category_id', $post->blog_category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select></div>
            <div class="form-group"><label>Excerpt</label><textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $post->excerpt) }}</textarea></div>
            <div class="form-group"><label>Content *</label><textarea name="content" class="form-control" rows="10" required>{{ old('content', $post->content) }}</textarea></div>
            <div class="form-group"><label>Tags (comma separated)</label><input type="text" name="tags" class="form-control" value="{{ old('tags', $post->getTagsString()) }}"></div>
            <div class="form-group"><label>Status *</label><select name="status" class="form-control">@foreach(['draft','scheduled','published'] as $s)<option value="{{ $s }}" {{ old('status', $post->status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>
            <div class="form-check"><input type="checkbox" name="allow_comments" value="1" class="form-check-input" {{ old('allow_comments', $post->allow_comments) ? 'checked' : '' }}><label class="form-check-label">Allow comments</label></div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Update</button><a href="{{ route('admin.blog.posts.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
