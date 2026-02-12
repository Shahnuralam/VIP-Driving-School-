@extends('adminlte::page')

@section('title', 'Edit Page')

@section('content_header')
    <h1>Edit Page: {{ $page->title }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Page Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $page->title) }}" placeholder="Enter page title" required>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">URL Slug</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">/</span>
                            </div>
                            <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" 
                                   value="{{ old('slug', $page->slug) }}" placeholder="Auto-generated if empty">
                        </div>
                        @error('slug')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Leave empty to auto-generate from title</small>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" rows="15" 
                                  class="form-control @error('content') is-invalid @enderror" 
                                  placeholder="Enter page content (HTML allowed)">{{ old('content', $page->content) }}</textarea>
                        @error('content')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">SEO Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3" 
                                          class="form-control @error('meta_description') is-invalid @enderror" 
                                          placeholder="Brief description for search engines" maxlength="500">{{ old('meta_description', $page->meta_description) }}</textarea>
                                @error('meta_description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Max 500 characters</small>
                            </div>

                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" name="meta_keywords" id="meta_keywords" 
                                       class="form-control @error('meta_keywords') is-invalid @enderror" 
                                       value="{{ old('meta_keywords', $page->meta_keywords) }}" placeholder="keyword1, keyword2, keyword3">
                                @error('meta_keywords')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Featured Image</h3>
                        </div>
                        <div class="card-body">
                            @if($page->featured_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $page->featured_image) }}" alt="Featured Image" class="img-fluid rounded" style="max-height: 150px;">
                                <p class="text-muted small mt-1 mb-0">Current image</p>
                            </div>
                            @endif
                            <div class="form-group mb-0">
                                <label for="featured_image">{{ $page->featured_image ? 'Replace Image' : 'Upload Image' }}</label>
                                <input type="file" name="featured_image" id="featured_image" 
                                       class="form-control-file @error('featured_image') is-invalid @enderror" 
                                       accept="image/jpeg,image/png,image/jpg,image/gif">
                                @error('featured_image')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Accepted: JPEG, PNG, JPG, GIF (max 2MB)</small>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Menu Display</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="show_in_navbar" name="show_in_navbar" value="1" {{ old('show_in_navbar', $page->show_in_navbar) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="show_in_navbar">Show in Navigation Menu</label>
                                </div>
                                <small class="text-muted">Display this page in the top navigation bar</small>
                            </div>

                            <div class="form-group">
                                <label for="navbar_order">Navbar Order</label>
                                <input type="number" name="navbar_order" id="navbar_order" min="0" 
                                       class="form-control @error('navbar_order') is-invalid @enderror" 
                                       value="{{ old('navbar_order', $page->navbar_order) }}">
                                @error('navbar_order')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="show_in_footer" name="show_in_footer" value="1" {{ old('show_in_footer', $page->show_in_footer) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="show_in_footer">Show in Footer Menu</label>
                                </div>
                                <small class="text-muted">Display this page in the footer section</small>
                            </div>

                            <div class="form-group mb-0">
                                <label for="footer_order">Footer Order</label>
                                <input type="number" name="footer_order" id="footer_order" min="0" 
                                       class="form-control @error('footer_order') is-invalid @enderror" 
                                       value="{{ old('footer_order', $page->footer_order) }}">
                                @error('footer_order')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Page Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="sort_order">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order" min="0" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       value="{{ old('sort_order', $page->sort_order) }}">
                                @error('sort_order')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Page Info</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Created:</strong> {{ $page->created_at->format('M d, Y H:i') }}</p>
                            <p class="mb-0"><strong>Updated:</strong> {{ $page->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Page
            </button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
            <a href="{{ url('/' . $page->slug) }}" class="btn btn-outline-info float-right" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Page
            </a>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('blur', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value) {
            slugInput.value = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
        }
    });
</script>
@stop
