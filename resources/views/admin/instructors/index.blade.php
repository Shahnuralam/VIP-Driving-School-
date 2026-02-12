@extends('adminlte::page')

@section('title', 'Instructors')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Instructors</h1>
        <a href="{{ route('admin.instructors.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Instructor</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Name</th><th>Email</th><th>Phone</th><th>Rating</th><th>Bookings</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($instructors as $i)
                <tr>
                    <td>{{ $i->name }}</td>
                    <td>{{ $i->email }}</td>
                    <td>{{ $i->phone }}</td>
                    <td>{{ number_format($i->rating, 1) }} <i class="fas fa-star text-warning"></i></td>
                    <td>{{ $i->bookings_count }}</td>
                    <td><span class="badge badge-{{ $i->is_active ? 'success' : 'secondary' }}">{{ $i->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <a href="{{ route('admin.instructors.availability', $i) }}" class="btn btn-sm btn-info" title="Availability"><i class="fas fa-calendar"></i></a>
                        <a href="{{ route('admin.instructors.edit', $i) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">No instructors yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($instructors->hasPages())
    <div class="card-footer">{{ $instructors->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
