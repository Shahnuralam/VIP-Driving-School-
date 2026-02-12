@extends('adminlte::page')

@section('title', 'Upload Document')

@section('content_header')
    <h1>Upload New Document</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Document Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" placeholder="Enter document title" required>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">URL Slug</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">/documents/</span>
                            </div>
                            <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" 
                                   value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                        </div>
                        @error('slug')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Leave empty to auto-generate from title</small>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="4" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Brief description of the document">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="file">Document File <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" name="file" id="file" 
                                   class="custom-file-input @error('file') is-invalid @enderror" 
                                   accept=".pdf,.doc,.docx" required>
                            <label class="custom-file-label" for="file">Choose file...</label>
                        </div>
                        @error('file')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Accepted: PDF, DOC, DOCX (max 10MB)</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    <option value="assessment" {{ old('category') === 'assessment' ? 'selected' : '' }}>Assessment</option>
                                    <option value="forms" {{ old('category') === 'forms' ? 'selected' : '' }}>Forms</option>
                                    <option value="guides" {{ old('category') === 'guides' ? 'selected' : '' }}>Guides</option>
                                    <option value="terms" {{ old('category') === 'terms' ? 'selected' : '' }}>Terms & Conditions</option>
                                    <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sort_order">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order" min="0" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       value="{{ old('sort_order', 0) }}">
                                @error('sort_order')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload Document
            </button>
            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
    // Custom file input label
    document.getElementById('file').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file...';
        var label = document.querySelector('label[for="file"]');
        label.textContent = fileName;
    });

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
