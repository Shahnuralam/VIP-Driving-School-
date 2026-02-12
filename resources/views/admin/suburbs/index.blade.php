@extends('adminlte::page')

@section('title', 'Service Areas / Suburbs')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Service Areas / Suburbs</h1>
        <a href="{{ route('admin.suburbs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Suburb</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr><th>Name</th><th>Postcode</th><th>Instructors</th><th>Serviced</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($suburbs as $s)
                <tr>
                    <td>{{ $s->name }}</td>
                    <td>{{ $s->postcode ?? '-' }}</td>
                    <td>{{ $s->instructors_count ?? 0 }}</td>
                    <td><span class="badge badge-{{ $s->is_serviced ? 'success' : 'secondary' }}">{{ $s->is_serviced ? 'Yes' : 'No' }}</span></td>
                    <td>
                        <a href="{{ route('admin.suburbs.edit', $s) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No suburbs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($suburbs->hasPages())
    <div class="card-footer">{{ $suburbs->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
@stop
