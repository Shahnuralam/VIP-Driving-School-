@extends('adminlte::page')

@section('title', 'Add Package')

@section('content_header')
    <h1>Add New Lesson Package</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.packages.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Package Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="e.g., 3 x 50 Minute Lesson" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">URL Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" 
                               value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                        @error('slug')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lesson_count">Number of Lessons <span class="text-danger">*</span></label>
                                <input type="number" name="lesson_count" id="lesson_count" min="1" 
                                       class="form-control @error('lesson_count') is-invalid @enderror" 
                                       value="{{ old('lesson_count', 3) }}" required>
                                @error('lesson_count')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lesson_duration">Minutes per Lesson <span class="text-danger">*</span></label>
                                <input type="number" name="lesson_duration" id="lesson_duration" min="1" 
                                       class="form-control @error('lesson_duration') is-invalid @enderror" 
                                       value="{{ old('lesson_duration', 50) }}" required>
                                @error('lesson_duration')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Package Price ($) <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" step="0.01" min="0" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price') }}" required>
                                @error('price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="original_price">Original Price ($)</label>
                                <input type="number" name="original_price" id="original_price" step="0.01" min="0" 
                                       class="form-control @error('original_price') is-invalid @enderror" 
                                       value="{{ old('original_price') }}" placeholder="For showing savings">
                                @error('original_price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tagline">Tagline</label>
                        <input type="text" name="tagline" id="tagline" class="form-control @error('tagline') is-invalid @enderror" 
                               value="{{ old('tagline') }}" placeholder="e.g., An Affordable and Practical Start">
                        @error('tagline')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="4" 
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="validity_days">Validity (Days) <span class="text-danger">*</span></label>
                                <input type="number" name="validity_days" id="validity_days" min="1" 
                                       class="form-control @error('validity_days') is-invalid @enderror" 
                                       value="{{ old('validity_days', 365) }}" required>
                                @error('validity_days')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="validity_text">Validity Text</label>
                                <input type="text" name="validity_text" id="validity_text" 
                                       class="form-control @error('validity_text') is-invalid @enderror" 
                                       value="{{ old('validity_text', 'Valid for one year') }}">
                                @error('validity_text')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
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

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_featured">Most Popular (Featured Badge)</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Package
            </button>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop
