@extends('adminlte::page')

@section('title', $instructor->name)

@section('content_header')
    <h1>{{ $instructor->name }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Email:</strong> {{ $instructor->email }} &bull; <strong>Phone:</strong> {{ $instructor->phone }}</p>
        <p><strong>Rating:</strong> {{ number_format($instructor->rating, 1) }} ({{ $instructor->total_reviews }} reviews) &bull; <strong>Lessons:</strong> {{ $instructor->total_lessons }}</p>
        <a href="{{ route('admin.instructors.availability', $instructor) }}" class="btn btn-info">Manage Availability</a>
        <a href="{{ route('admin.instructors.edit', $instructor) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.instructors.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@stop
