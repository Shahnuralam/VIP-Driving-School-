@extends('adminlte::page')

@section('title', 'Add FAQ')

@section('content_header')
    <h1>Add New FAQ</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="question">Question <span class="text-danger">*</span></label>
                        <input type="text" name="question" id="question" 
                               class="form-control @error('question') is-invalid @enderror" 
                               value="{{ old('question') }}" 
                               placeholder="Enter the frequently asked question" required>
                        @error('question')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="answer">Answer <span class="text-danger">*</span></label>
                        <textarea name="answer" id="answer" rows="6" 
                                  class="form-control @error('answer') is-invalid @enderror" 
                                  placeholder="Enter the answer (HTML allowed)" required>{{ old('answer') }}</textarea>
                        @error('answer')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Categorization</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>General</option>
                                    <option value="packages" {{ old('category') === 'packages' ? 'selected' : '' }}>Packages</option>
                                    <option value="booking" {{ old('category') === 'booking' ? 'selected' : '' }}>Booking</option>
                                    <option value="payment" {{ old('category') === 'payment' ? 'selected' : '' }}>Payment</option>
                                    <option value="lessons" {{ old('category') === 'lessons' ? 'selected' : '' }}>Lessons</option>
                                    <option value="assessments" {{ old('category') === 'assessments' ? 'selected' : '' }}>Assessments</option>
                                </select>
                                @error('category')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="page">Display on Page</label>
                                <select name="page" id="page" class="form-control @error('page') is-invalid @enderror">
                                    <option value="">All Pages (Global)</option>
                                    <option value="home" {{ old('page') === 'home' ? 'selected' : '' }}>Homepage</option>
                                    <option value="lesson-packages" {{ old('page') === 'lesson-packages' ? 'selected' : '' }}>Lesson Packages</option>
                                    <option value="book-online" {{ old('page') === 'book-online' ? 'selected' : '' }}>Online Booking</option>
                                    <option value="p1-assessments" {{ old('page') === 'p1-assessments' ? 'selected' : '' }}>P1 Assessments</option>
                                    <option value="contact" {{ old('page') === 'contact' ? 'selected' : '' }}>Contact</option>
                                </select>
                                @error('page')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Leave empty to show on all pages</small>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Settings</h3>
                        </div>
                        <div class="card-body">
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
                <i class="fas fa-save"></i> Save FAQ
            </button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop
