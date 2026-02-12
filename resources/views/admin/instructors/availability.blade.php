@extends('adminlte::page')

@section('title', 'Instructor Availability')

@section('content_header')
    <h1>Availability: {{ $instructor->name }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">Add Unavailability</div>
    <div class="card-body">
        <form action="{{ route('admin.instructors.unavailability.store', $instructor) }}" method="POST" class="form-inline">
            @csrf
            <input type="date" name="date" class="form-control mr-2" required>
            <input type="time" name="start_time" class="form-control mr-2" placeholder="From (optional)">
            <input type="time" name="end_time" class="form-control mr-2" placeholder="To (optional)">
            <input type="text" name="reason" class="form-control mr-2" placeholder="Reason">
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header">Upcoming Unavailabilities</div>
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            @forelse($unavailabilities as $u)
            <tr>
                <td>{{ $u->date->format('M j, Y') }}</td>
                <td>{{ $u->start_time ? \Carbon\Carbon::parse($u->start_time)->format('g:i A') . ' - ' . \Carbon\Carbon::parse($u->end_time)->format('g:i A') : 'All day' }}</td>
                <td>{{ $u->reason }}</td>
                <td>
                    <form action="{{ route('admin.instructors.unavailability.destroy', [$instructor, $u]) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger">Remove</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-muted">No unavailabilities.</td></tr>
            @endforelse
        </table>
    </div>
</div>
<a href="{{ route('admin.instructors.index') }}" class="btn btn-secondary mt-3">Back to Instructors</a>
@stop
