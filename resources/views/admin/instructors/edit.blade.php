@extends('adminlte::page')

@section('title', 'Edit Instructor')

@section('content_header')
    <h1>Edit: {{ $instructor->name }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.instructors.update', $instructor) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"><label>Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name', $instructor->name) }}"></div>
                    <div class="form-group"><label>Email *</label><input type="email" name="email" class="form-control" required value="{{ old('email', $instructor->email) }}"></div>
                    <div class="form-group"><label>Phone *</label><input type="text" name="phone" class="form-control" required value="{{ old('phone', $instructor->phone) }}"></div>
                    <div class="form-group"><label>Bio</label><textarea name="bio" class="form-control" rows="3">{{ old('bio', $instructor->bio) }}</textarea></div>
                    <div class="form-group"><label>Photo</label><input type="file" name="photo" class="form-control-file" accept="image/*">@if($instructor->photo)<br><small>Current: {{ $instructor->photo }}</small>@endif</div>
                </div>
                <div class="col-md-6">
                    @php $days = old('available_days', $instructor->available_days ?? []); $days = is_array($days) ? $days : []; @endphp
                    <div class="form-group"><label>Available Days</label><br>@foreach(['monday','tuesday','wednesday','thursday','friday','saturday'] as $d)<div class="form-check form-check-inline"><input type="checkbox" name="available_days[]" value="{{ $d }}" class="form-check-input" {{ in_array($d, array_map('strtolower', $days)) ? 'checked' : '' }}><label class="form-check-label">{{ ucfirst($d) }}</label></div>@endforeach</div>
                    <div class="form-group"><label>Available From</label><input type="time" name="available_from" class="form-control" value="{{ old('available_from', $instructor->available_from ? \Carbon\Carbon::parse($instructor->available_from)->format('H:i') : '08:00') }}"></div>
                    <div class="form-group"><label>Available To</label><input type="time" name="available_to" class="form-control" value="{{ old('available_to', $instructor->available_to ? \Carbon\Carbon::parse($instructor->available_to)->format('H:i') : '18:00') }}"></div>
                    <div class="form-group"><label>Suburbs</label><select name="suburbs[]" class="form-control" multiple>@foreach($suburbs as $s)<option value="{{ $s->id }}" {{ $instructor->suburbs->contains($s) ? 'selected' : '' }}>{{ $s->name }}</option>@endforeach</select></div>
                    <div class="form-check"><input type="checkbox" name="is_featured" value="1" class="form-check-input" {{ old('is_featured', $instructor->is_featured) ? 'checked' : '' }}><label class="form-check-label">Featured</label></div>
                    <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', $instructor->is_active) ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
                </div>
            </div>
        </div>
        <div class="card-footer"><button type="submit" class="btn btn-primary">Update</button><a href="{{ route('admin.instructors.index') }}" class="btn btn-secondary">Cancel</a></div>
    </form>
</div>
@stop
