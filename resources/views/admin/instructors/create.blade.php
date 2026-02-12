@extends('adminlte::page')

@section('title', 'Add Instructor')

@section('content_header')
    <h1>Add Instructor</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.instructors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"><label>Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}"></div>
                    <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
                    <div class="form-group"><label>Phone *</label><input type="text" name="phone" class="form-control" required value="{{ old('phone') }}"></div>
                    <div class="form-group"><label>Bio</label><textarea name="bio" class="form-control" rows="3">{{ old('bio') }}</textarea></div>
                    <div class="form-group"><label>Years Experience</label><input type="number" name="years_experience" class="form-control" min="0" value="{{ old('years_experience', 0) }}"></div>
                    <div class="form-group"><label>Photo</label><input type="file" name="photo" class="form-control-file" accept="image/*"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label>Available Days</label><br>@foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $d)<div class="form-check form-check-inline"><input type="checkbox" name="available_days[]" value="{{ strtolower($d) }}" class="form-check-input" {{ in_array(strtolower($d), old('available_days', [])) ? 'checked' : '' }}><label class="form-check-label">{{ $d }}</label></div>@endforeach</div>
                    <div class="form-group"><label>Available From</label><input type="time" name="available_from" class="form-control" value="{{ old('available_from', '08:00') }}"></div>
                    <div class="form-group"><label>Available To</label><input type="time" name="available_to" class="form-control" value="{{ old('available_to', '18:00') }}"></div>
                    <div class="form-group"><label>Service Areas (Suburbs)</label><select name="suburbs[]" class="form-control" multiple>@foreach($suburbs as $s)<option value="{{ $s->id }}" {{ in_array($s->id, old('suburbs', [])) ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select><small class="text-muted">Hold Ctrl to select multiple</small></div>
                    <div class="form-check"><input type="checkbox" name="is_featured" value="1" class="form-check-input" {{ old('is_featured') ? 'checked' : '' }}><label class="form-check-label">Featured</label></div>
                    <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
                </div>
            </div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Create</button><a href="{{ route('admin.instructors.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
