@extends('adminlte::page')

@section('title', 'Add Location')

@section('content_header')
    <h1>Add New Location</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.locations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Location Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="e.g., North Hobart" required>
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

                    <div class="form-group">
                        <label for="address">Full Address <span class="text-danger">*</span></label>
                        <textarea name="address" id="address" rows="2" 
                                  class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                        @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="departure_info">Departure Info</label>
                        <textarea name="departure_info" id="departure_info" rows="2" 
                                  class="form-control @error('departure_info') is-invalid @enderror" 
                                  placeholder="e.g., Departing from the corner of Ryde St & Letitia St">{{ old('departure_info') }}</textarea>
                        @error('departure_info')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="number" name="latitude" id="latitude" step="0.00000001" 
                                       class="form-control @error('latitude') is-invalid @enderror" 
                                       value="{{ old('latitude') }}" placeholder="-42.8821">
                                @error('latitude')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="number" name="longitude" id="longitude" step="0.00000001" 
                                       class="form-control @error('longitude') is-invalid @enderror" 
                                       value="{{ old('longitude') }}" placeholder="147.3272">
                                @error('longitude')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Available Days</label>
                        <div class="row">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="day_{{ $day }}" 
                                           name="available_days[]" value="{{ $day }}"
                                           {{ in_array($day, old('available_days', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="day_{{ $day }}">{{ $day }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="available_days_text">Available Days Text</label>
                        <input type="text" name="available_days_text" id="available_days_text" 
                               class="form-control @error('available_days_text') is-invalid @enderror" 
                               value="{{ old('available_days_text') }}" placeholder="e.g., Mondays, Wednesdays & Fridays">
                        @error('available_days_text')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="map_embed_code">Google Maps Embed Code</label>
                        <textarea name="map_embed_code" id="map_embed_code" rows="3" 
                                  class="form-control @error('map_embed_code') is-invalid @enderror" 
                                  placeholder="Paste Google Maps iframe code here">{{ old('map_embed_code') }}</textarea>
                        @error('map_embed_code')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Location Image</label>
                        <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                        @error('image')
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
                <i class="fas fa-save"></i> Save Location
            </button>
            <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop
