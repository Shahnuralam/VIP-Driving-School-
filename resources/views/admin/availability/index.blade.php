@extends('adminlte::page')

@section('title', 'Availability Slots')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-calendar-alt mr-2"></i>Availability Slots</h1>
        <div>
            <a href="{{ route('admin.availability.bulk-create') }}" class="btn btn-info">
                <i class="fas fa-calendar-plus mr-1"></i>Bulk Create
            </a>
            <a href="{{ route('admin.availability.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i>Add Slot
            </a>
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter Slots</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.availability.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Service</label>
                            <select name="service_id" class="form-control select2">
                                <option value="">All Services</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Location</label>
                            <select name="location_id" class="form-control select2">
                                <option value="">All Locations</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date From</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date To</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.availability.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Slots Table -->
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Service</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slots as $slot)
                        <tr>
                            <td>
                                <strong>{{ $slot->date->format('D, M j, Y') }}</strong>
                            </td>
                            <td>{{ $slot->time_range }}</td>
                            <td>
                                @if($slot->service)
                                    {{ $slot->service->name }}
                                @else
                                    <span class="text-muted">All Services</span>
                                @endif
                            </td>
                            <td>
                                @if($slot->location)
                                    {{ $slot->location->name }}
                                @else
                                    <span class="text-muted">All Locations</span>
                                @endif
                            </td>
                            <td>
                                <span class="{{ $slot->remaining > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $slot->current_bookings }}/{{ $slot->max_bookings }}
                                </span>
                            </td>
                            <td>
                                @if($slot->is_blocked)
                                    <span class="badge badge-danger">Blocked</span>
                                @elseif(!$slot->is_available)
                                    <span class="badge badge-warning">Unavailable</span>
                                @elseif($slot->isFull())
                                    <span class="badge badge-secondary">Full</span>
                                @else
                                    <span class="badge badge-success">Available</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.availability.edit', $slot) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.availability.toggle-block', $slot) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $slot->is_blocked ? 'btn-success' : 'btn-warning' }}" title="{{ $slot->is_blocked ? 'Unblock' : 'Block' }}">
                                        <i class="fas {{ $slot->is_blocked ? 'fa-unlock' : 'fa-ban' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.availability.destroy', $slot) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this slot?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No availability slots found. <a href="{{ route('admin.availability.create') }}">Create one</a> or <a href="{{ route('admin.availability.bulk-create') }}">bulk create slots</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($slots->hasPages())
            <div class="card-footer">
                {{ $slots->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4',
        allowClear: true,
        placeholder: 'Select...'
    });
});
</script>
@stop
