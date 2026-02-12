@extends('adminlte::page')

@section('title', 'Lesson Packages')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Lesson Packages</h1>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Package
        </a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Lessons</th>
                    <th>Price</th>
                    <th>Tagline</th>
                    <th>Validity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $package)
                <tr>
                    <td>{{ $package->id }}</td>
                    <td>
                        <strong>{{ $package->name }}</strong>
                        @if($package->is_featured)
                            <span class="badge badge-danger">Most Popular</span>
                        @endif
                    </td>
                    <td>{{ $package->lesson_count }} x {{ $package->lesson_duration }} min</td>
                    <td>{{ $package->formatted_price }}</td>
                    <td>{{ Str::limit($package->tagline, 30) }}</td>
                    <td>{{ $package->validity_text }}</td>
                    <td>
                        <span class="badge badge-{{ $package->is_active ? 'success' : 'secondary' }}">
                            {{ $package->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                    <td colspan="8" class="text-center text-muted">No packages found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $packages->links('pagination::bootstrap-4') }}
    </div>
</div>
@stop
