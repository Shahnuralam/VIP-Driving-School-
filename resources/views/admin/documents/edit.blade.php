@extends('adminlte::page')

@section('title', 'Edit Document')

@section('content_header')
    <h1>Edit Document: {{ $document->title }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Document Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $document->title) }}" placeholder="Enter document title" required>
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
                                   value="{{ old('slug', $document->slug) }}" placeholder="Auto-generated if empty">
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
                                  placeholder="Brief description of the document">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="file">Replace Document File</label>
                        <div class="custom-file">
                            <input type="file" name="file" id="file" 
                                   class="custom-file-input @error('file') is-invalid @enderror" 
                                   accept=".pdf,.doc,.docx">
                            <label class="custom-file-label" for="file">Choose new file...</label>
                        </div>
                        @error('file')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Leave empty to keep current file. Accepted: PDF, DOC, DOCX (max 10MB)</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Current File</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                @if($document->file_type === 'pdf')
                                    <i class="fas fa-file-pdf fa-3x text-danger mr-3"></i>
                                @elseif(in_array($document->file_type, ['doc', 'docx']))
                                    <i class="fas fa-file-word fa-3x text-primary mr-3"></i>
                                @else
                                    <i class="fas fa-file fa-3x text-secondary mr-3"></i>
                                @endif
                                <div>
                                    <strong>{{ $document->file_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $document->formatted_size }}</small>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="fas fa-download mr-1"></i>Download Current File
                            </a>
                        </div>
                    </div>

                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    <option value="assessment" {{ old('category', $document->category) === 'assessment' ? 'selected' : '' }}>Assessment</option>
                                    <option value="forms" {{ old('category', $document->category) === 'forms' ? 'selected' : '' }}>Forms</option>
                                    <option value="guides" {{ old('category', $document->category) === 'guides' ? 'selected' : '' }}>Guides</option>
                                    <option value="terms" {{ old('category', $document->category) === 'terms' ? 'selected' : '' }}>Terms & Conditions</option>
                                    <option value="other" {{ old('category', $document->category) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sort_order">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order" min="0" 
                                       class="form-control @error('sort_order') is-invalid @enderror" 
                                       value="{{ old('sort_order', $document->sort_order) }}">
                                @error('sort_order')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $document->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Document Stats</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Downloads:</strong> {{ $document->download_count ?? 0 }}</p>
                            <p class="mb-1"><strong>Created:</strong> {{ $document->created_at->format('M d, Y H:i') }}</p>
                            <p class="mb-0"><strong>Updated:</strong> {{ $document->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Document
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
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose new file...';
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
