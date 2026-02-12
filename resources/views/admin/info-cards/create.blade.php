@extends('adminlte::page')

@section('title', 'Add Info Card')

@section('content_header')
    <h1>Add New Info Card</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.info-cards.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" placeholder="Enter card title" required>
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="5" 
                                  class="form-control @error('content') is-invalid @enderror" 
                                  placeholder="Enter card content" required>{{ old('content') }}</textarea>
                        @error('content')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link_url">Link URL</label>
                                <input type="url" name="link_url" id="link_url" 
                                       class="form-control @error('link_url') is-invalid @enderror" 
                                       value="{{ old('link_url') }}" placeholder="https://example.com">
                                @error('link_url')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link_text">Link Text</label>
                                <input type="text" name="link_text" id="link_text" 
                                       class="form-control @error('link_text') is-invalid @enderror" 
                                       value="{{ old('link_text') }}" placeholder="Learn More">
                                @error('link_text')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Icon Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Icon Type <span class="text-danger">*</span></label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="icon_type_fa" name="icon_type" value="fontawesome" class="custom-control-input" {{ old('icon_type', 'fontawesome') === 'fontawesome' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="icon_type_fa">Font Awesome Icon</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="icon_type_img" name="icon_type" value="image" class="custom-control-input" {{ old('icon_type') === 'image' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="icon_type_img">Upload Image</label>
                                </div>
                            </div>

                            <div class="form-group" id="fa_icon_group">
                                <label for="icon">Font Awesome Class</label>
                                <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" 
                                       value="{{ old('icon') }}" placeholder="fas fa-car">
                                @error('icon')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">e.g., fas fa-car, fas fa-road, fas fa-clock</small>
                            </div>

                            <div class="form-group" id="img_icon_group" style="display: none;">
                                <label for="icon_image">Icon Image</label>
                                <input type="file" name="icon_image" id="icon_image" 
                                       class="form-control-file @error('icon_image') is-invalid @enderror" 
                                       accept="image/*">
                                @error('icon_image')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Recommended: Square, max 2MB</small>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Display Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="page">Page <span class="text-danger">*</span></label>
                                <select name="page" id="page" class="form-control @error('page') is-invalid @enderror" required>
                                    <option value="">Select Page</option>
                                    <option value="home" {{ old('page') === 'home' ? 'selected' : '' }}>Homepage</option>
                                    <option value="lesson-packages" {{ old('page') === 'lesson-packages' ? 'selected' : '' }}>Lesson Packages</option>
                                    <option value="book-online" {{ old('page') === 'book-online' ? 'selected' : '' }}>Online Booking</option>
                                    <option value="p1-assessments" {{ old('page') === 'p1-assessments' ? 'selected' : '' }}>P1 Assessments</option>
                                </select>
                                @error('page')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="section">Section</label>
                                <input type="text" name="section" id="section" 
                                       class="form-control @error('section') is-invalid @enderror" 
                                       value="{{ old('section') }}" placeholder="e.g., things-to-know">
                                @error('section')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Optional section identifier</small>
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
                <i class="fas fa-save"></i> Save Info Card
            </button>
            <a href="{{ route('admin.info-cards.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
    document.querySelectorAll('input[name="icon_type"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.getElementById('fa_icon_group').style.display = this.value === 'fontawesome' ? 'block' : 'none';
            document.getElementById('img_icon_group').style.display = this.value === 'image' ? 'block' : 'none';
        });
    });
    // Initialize on page load
    document.querySelector('input[name="icon_type"]:checked').dispatchEvent(new Event('change'));
</script>
@stop
