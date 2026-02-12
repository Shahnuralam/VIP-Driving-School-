@extends('adminlte::page')

@section('title', 'Locations')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Assessment & Lesson Locations</h1>
        <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Location
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Available Days</th>
                    <th>Services</th>
                    <th>Bookings</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $location)
                <tr>
                    <td>{{ $location->id }}</td>
                    <td><strong>{{ $location->name }}</strong></td>
                    <td>{{ Str::limit($location->address, 40) }}</td>
                    <td>{{ $location->formatted_days }}</td>
                    <td><span class="badge badge-info">{{ $location->services_count }}</span></td>
                    <td><span class="badge badge-primary">{{ $location->bookings_count }}</span></td>
                    <td>
                        <span class="badge badge-{{ $location->is_active ? 'success' : 'secondary' }}">
                            {{ $location->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No locations found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $locations->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop
