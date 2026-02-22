@extends('adminlte::page')

@section('title', 'Appointment Slots')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-calendar-alt mr-2"></i>Appointment Slots</h1>
        <div>
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#blockedDatesModal">
                <i class="fas fa-ban mr-1"></i>Blocked Dates
            </button>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#bulkCreateModal">
                <i class="fas fa-calendar-plus mr-1"></i>Bulk Create
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createSlotModal">
                <i class="fas fa-plus mr-1"></i>Add Slot
            </button>
            <a href="#" id="toggle-view-btn" class="btn btn-info">
                <i class="fas fa-list mr-1"></i>List View
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
                    <div class="col-md-2">
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
                    <div class="col-md-2">
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
                            <label>Instructor</label>
                            <select name="instructor_id" class="form-control select2">
                                <option value="">All Instructors</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }}
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
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('admin.availability.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- List View Container -->
    <div id="list-view-container" style="display: none;">
        <div class="card">
            <div class="card-header">
                <div id="bulk-actions-toolbar" style="display: none;">
                    <button type="button" class="btn btn-danger btn-sm" id="bulk-delete-btn">
                        <i class="fas fa-trash mr-1"></i>Delete Selected (<span id="selected-count">0</span>)
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm ml-2" id="cancel-selection-btn">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="30">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="select-all-slots">
                                    <label class="custom-control-label" for="select-all-slots"></label>
                                </div>
                            </th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Instructor</th>
                            <th>Service</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slots as $slot)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input slot-checkbox" id="slot_{{ $slot->id }}" value="{{ $slot->id }}" data-has-bookings="{{ $slot->current_bookings > 0 ? 'true' : 'false' }}">
                                        <label class="custom-control-label" for="slot_{{ $slot->id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $slot->date->format('D, M j, Y') }}</strong>
                                    @if($slot->pattern_type && $slot->pattern_type !== 'manual')
                                        <br>
                                        @if($slot->pattern_type === 'daily')
                                            <span class="badge badge-primary badge-sm" title="Created via Daily Recurring pattern">
                                                <i class="fas fa-sync-alt"></i> Daily
                                            </span>
                                        @elseif($slot->pattern_type === 'weekly')
                                            <span class="badge badge-info badge-sm" title="Created via Weekly Recurring pattern">
                                                <i class="fas fa-calendar-week"></i> Weekly
                                            </span>
                                        @elseif($slot->pattern_type === 'monthly')
                                            <span class="badge badge-warning badge-sm" title="Created via Monthly Recurring pattern">
                                                <i class="fas fa-calendar-alt"></i> Monthly
                                            </span>
                                        @elseif($slot->pattern_type === 'onetime')
                                            <span class="badge badge-secondary badge-sm" title="Created via one-time pattern">
                                                <i class="fas fa-layer-group"></i> One-time
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $slot->time_range }}</td>
                                <td>
                                    @if(!empty($slot->instructor_names))
                                        @foreach($slot->instructor_names as $name)
                                            <span class="badge badge-info">{{ $name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-primary">Global (All)</span>
                                    @endif
                                </td>
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
                                    <button type="button" class="btn btn-sm btn-danger instant-delete-btn" data-slot-id="{{ $slot->id }}" data-has-bookings="{{ $slot->current_bookings > 0 ? 'true' : 'false' }}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
    </div>

    <!-- Calendar View Container -->
    <div id="calendar-view-container">
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Create Slot Modal -->
    <div class="modal fade" id="createSlotModal" role="dialog" aria-labelledby="createSlotModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSlotModalLabel">Create Availability Slot</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.availability.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Service (Optional)</label>
                                    <select name="service_id" class="form-control select2" style="width: 100%;">
                                        <option value="">All Services</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Location (Optional)</label>
                                    <select name="location_id" class="form-control select2" style="width: 100%;">
                                        <option value="">All Locations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Instructor(s) (Optional)</label>
                                    <select name="instructor_ids[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{ (collect(old('instructor_ids'))->contains($instructor->id)) ? 'selected' : '' }}>
                                                {{ $instructor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label id="create_date_label">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="create_date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Start Time <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time', '09:00') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>End Time <span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time', '10:00') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields to maintain default values -->
                        <input type="hidden" name="max_bookings" value="1">
                        <input type="hidden" name="is_available" value="1">

                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Pattern Type</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="create_pattern_onetime" name="pattern_type" value="onetime" {{ old('pattern_type', 'onetime') === 'onetime' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="create_pattern_onetime">One-time</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="create_pattern_daily" name="pattern_type" value="daily" {{ old('pattern_type') === 'daily' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="create_pattern_daily">Every day</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="create_pattern_weekly" name="pattern_type" value="weekly" {{ old('pattern_type') === 'weekly' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="create_pattern_weekly">Weekly</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="create_pattern_monthly" name="pattern_type" value="monthly" {{ old('pattern_type') === 'monthly' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="create_pattern_monthly">Monthly</label>
                                        </div>
                                    </div>
                                </div>

                                <div id="create_recurring_duration_section" class="form-group mt-3" style="display: none;">
                                    <label>Duration <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="duration_value" class="form-control" id="create_duration_value">
                                                <option value="1" {{ old('duration_value', '1') == '1' ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ old('duration_value') == '2' ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ old('duration_value') == '3' ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ old('duration_value') == '4' ? 'selected' : '' }}>4</option>
                                                <option value="6" {{ old('duration_value') == '6' ? 'selected' : '' }}>6</option>
                                                <option value="12" {{ old('duration_value') == '12' ? 'selected' : '' }}>12</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="duration_unit" class="form-control" id="create_duration_unit">
                                                <option value="weeks" {{ old('duration_unit', 'weeks') === 'weeks' ? 'selected' : '' }}>Weeks</option>
                                                <option value="months" {{ old('duration_unit') === 'months' ? 'selected' : '' }}>Months</option>
                                            </select>
                                        </div>
                                    </div>
                                    <small class="text-muted" id="create_duration_help_text">Slots will be created from start date for this duration.</small>
                                </div>

                                <div class="form-group mb-0" id="create_days_of_week_section" style="display: none;">
                                    <label>Days of Week <span class="text-danger">*</span></label>
                                    <div class="row">
                                        @php
                                            $createDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                            $selectedCreateDays = old('days', [1, 2, 3, 4, 5]);
                                        @endphp
                                        @foreach($createDays as $index => $day)
                                            <div class="col-md-3 col-6">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input create-day-checkbox" id="create_modal_day_{{ $index }}" name="days[]" value="{{ $index }}" {{ in_array($index, (array) $selectedCreateDays) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="create_modal_day_{{ $index }}">{{ $day }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Slot</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Create Modal -->
    <div class="modal fade" id="bulkCreateModal" role="dialog" aria-labelledby="bulkCreateModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkCreateModalLabel">Bulk Create Slots</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.availability.bulk-store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Create multiple slots at once. Choose one-time or recurring patterns.
                        </div>

                        <!-- Recurring Pattern Section -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Pattern Type</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="pattern_onetime" name="pattern_type" value="onetime" checked>
                                                <label class="custom-control-label" for="pattern_onetime">
                                                    <strong>One-time</strong><br>
                                                    <small class="text-muted">Create slots for specific date range</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="pattern_daily" name="pattern_type" value="daily">
                                                <label class="custom-control-label" for="pattern_daily">
                                                    <strong>Daily Recurring</strong><br>
                                                    <small class="text-muted">Repeat every day</small>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="pattern_weekly" name="pattern_type" value="weekly">
                                                <label class="custom-control-label" for="pattern_weekly">
                                                    <strong>Weekly Recurring</strong><br>
                                                    <small class="text-muted">Repeat on selected days</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Duration field (shown for recurring patterns) -->
                                <div id="recurring_duration_section" class="form-group" style="display: none;">
                                    <label>Duration <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="duration_value" class="form-control" id="duration_value">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3" selected>3</option>
                                                <option value="6">6</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="duration_unit" class="form-control" id="duration_unit">
                                                <option value="months" selected>Months</option>
                                                <option value="weeks">Weeks</option>
                                            </select>
                                        </div>
                                    </div>
                                    <small class="text-muted" id="duration_help_text">Slots will be created from start date for this duration</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Instructor(s) (Optional)</label>
                                    <select name="instructor_ids[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{ (collect(old('instructor_ids'))->contains($instructor->id)) ? 'selected' : '' }}>
                                                {{ $instructor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Service (Optional)</label>
                                    <select name="service_id" class="form-control select2" style="width: 100%;">
                                        <option value="">All Services</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location (Optional)</label>
                                    <select name="location_id" class="form-control select2" style="width: 100%;">
                                        <option value="">All Locations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="date_range_section">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label id="date_from_label">Date From <span class="text-danger">*</span></label>
                                    <input type="date" name="date_from" id="bulk_date_from" class="form-control" value="{{ old('date_from', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6" id="date_to_wrapper">
                                <div class="form-group">
                                    <label>Date To <span class="text-danger">*</span></label>
                                    <input type="date" name="date_to" id="bulk_date_to" class="form-control" value="{{ old('date_to', date('Y-m-d', strtotime('+1 month'))) }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="days_of_week_section">
                            <label>Days of Week <span class="text-danger" id="days_required">*</span></label>
                            <div class="row">
                                @php
                                    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                    $selectedDays = old('days', [1, 2, 3, 4, 5]);
                                @endphp
                                @foreach($days as $index => $day)
                                    <div class="col-md-3 col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input bulk-day-checkbox" id="bulk_day_{{ $index }}" name="days[]" value="{{ $index }}" {{ in_array($index, (array)$selectedDays) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="bulk_day_{{ $index }}">{{ $day }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Start Time <span class="text-danger">*</span></label>
                                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time', '09:00') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>End Time <span class="text-danger">*</span></label>
                                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time', '10:00') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden field for max_bookings -->
                        <input type="hidden" name="max_bookings" value="1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Bulk Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Blocked Dates Modal -->
    <div class="modal fade" id="blockedDatesModal" role="dialog" aria-labelledby="blockedDatesModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blockedDatesModalLabel">Blocked Dates</h5>
                    <div>
                         <button type="button" class="btn btn-primary btn-sm" id="btn-show-block-form">
                            <i class="fas fa-plus mr-1"></i>Block New Date
                        </button>
                         <button type="button" class="btn btn-secondary btn-sm d-none" id="btn-show-block-list">
                            <i class="fas fa-list mr-1"></i>Back to List
                        </button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- List View -->
                    <div id="blocked-dates-list">
                        <div id="blocked-dates-content">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Create Block Form -->
                    <div id="blocked-dates-form" class="d-none">
                        <form action="{{ route('admin.availability.block-date') }}" method="POST">
                            @csrf
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Warning:</strong> This will mark all existing slots in the selected range as <strong>Blocked</strong>.
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date From <span class="text-danger">*</span></label>
                                        <input type="date" name="date_from" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date To <span class="text-danger">*</span></label>
                                        <input type="date" name="date_to" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Instructor (Optional)</label>
                                <select name="instructor_id" class="form-control select2" style="width: 100%;">
                                    <option value="">All Instructors</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Leave empty to block slots for ALL instructors.</small>
                            </div>

                             <div class="form-group">
                                <label>Reason/Notes (Optional)</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-danger">Block Dates</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<style>
    #calendar {
        max-width: 100%;
    }
    .fc-event {
        cursor: pointer;
    }
    /* Fix Select2 Height and Vertical Alignment */
    .select2-container .select2-selection--single {
        height: calc(2.25rem + 2px) !important;
        padding: 0.375rem 0.75rem;
        display: flex;
        align-items: center;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 1.5 !important;
        padding-left: 0 !important;
        margin-top: -2px; /* slight adjustment for perfect center */
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem + 2px) !important;
        top: 0 !important;
    }
</style>
@stop

@section('js')
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize standard select2s on page
    $('.select2').select2({
        theme: 'bootstrap4',
        allowClear: true,
        placeholder: 'Select...'
    });

    // Re-initialize select2 when modals open
    $('#createSlotModal, #bulkCreateModal').on('shown.bs.modal', function () {
        $(this).find('.select2').select2({
            theme: 'bootstrap4',
            allowClear: true,
            placeholder: 'Select...',
            dropdownParent: $(this)
        });
    });

    // Load blocked dates when modal opens
    $('#blockedDatesModal').on('show.bs.modal', function () {
        loadBlockedDates();
        // Reset view to list
        $('#blocked-dates-form').addClass('d-none');
        $('#blocked-dates-list').removeClass('d-none');
        $('#btn-show-block-list').addClass('d-none');
        $('#btn-show-block-form').removeClass('d-none');
    });

    // Toggle between list and form in Blocked Dates modal
    $('#btn-show-block-form').click(function() {
        $('#blocked-dates-list').addClass('d-none');
        $('#blocked-dates-form').removeClass('d-none');
        $(this).addClass('d-none');
        $('#btn-show-block-list').removeClass('d-none');
    });

    $('#btn-show-block-list').click(function() {
        $('#blocked-dates-form').addClass('d-none');
        $('#blocked-dates-list').removeClass('d-none');
        $(this).addClass('d-none');
        $('#btn-show-block-form').removeClass('d-none');
        loadBlockedDates(); // Refresh list
    });

    function enforceCreateModalDurationLimitByUnit() {
        var patternType = $('#createSlotModal input[name="pattern_type"]:checked').val() || 'onetime';
        var durationUnitSelect = $('#create_duration_unit');
        var durationValueSelect = $('#create_duration_value');
        var weeksOption = durationUnitSelect.find('option[value="weeks"]');

        if (patternType === 'monthly') {
            weeksOption.prop('disabled', true);
            durationUnitSelect.val('months');
        } else {
            weeksOption.prop('disabled', false);
        }

        var durationUnit = durationUnitSelect.val();
        durationValueSelect.find('option').each(function() {
            var value = parseInt($(this).val(), 10);
            var isOverMonthLimit = durationUnit === 'months' && value > 3;
            $(this).prop('disabled', isOverMonthLimit).toggle(!isOverMonthLimit);
        });

        var currentValue = parseInt(durationValueSelect.val(), 10);
        if (durationUnit === 'months' && currentValue > 3) {
            durationValueSelect.val('3');
        }

        if (durationUnit === 'months') {
            $('#create_duration_help_text').text('When unit is months, maximum duration is 3 months.');
        } else {
            $('#create_duration_help_text').text('Slots will be created from start date for this duration.');
        }
    }

    function updateCreateModalPatternUI() {
        var patternType = $('#createSlotModal input[name="pattern_type"]:checked').val() || 'onetime';
        var isRecurring = patternType !== 'onetime';
        var isWeekly = patternType === 'weekly';

        $('#create_recurring_duration_section').toggle(isRecurring);
        $('#create_days_of_week_section').toggle(isWeekly);
        $('#create_date_label').html(
            isRecurring
                ? 'Start Date <span class="text-danger">*</span>'
                : 'Date <span class="text-danger">*</span>'
        );

        if (isWeekly && $('#create_days_of_week_section .create-day-checkbox:checked').length === 0) {
            $('#create_days_of_week_section .create-day-checkbox').prop('checked', false);
            $('#create_modal_day_1, #create_modal_day_2, #create_modal_day_3, #create_modal_day_4, #create_modal_day_5').prop('checked', true);
        }

        enforceCreateModalDurationLimitByUnit();
    }

    $('#createSlotModal input[name="pattern_type"]').change(function() {
        updateCreateModalPatternUI();
    });

    $('#create_duration_value, #create_duration_unit').change(function() {
        enforceCreateModalDurationLimitByUnit();
    });

    updateCreateModalPatternUI();

    // Handle pattern type changes in bulk create modal
    $('#bulkCreateModal input[name="pattern_type"]').change(function() {
        var patternType = $(this).val();
        
        if (patternType === 'onetime') {
            // One-time: show date range, days optional
            $('#recurring_duration_section').hide();
            $('#date_to_wrapper').show();
            $('#bulk_date_to').prop('required', true);
            $('#date_from_label').html('Date From <span class="text-danger">*</span>');
            $('#days_required').show();
            
        } else if (patternType === 'daily') {
            // Daily: show duration, hide date_to, days not needed
            $('#recurring_duration_section').show();
            $('#date_to_wrapper').hide();
            $('#bulk_date_to').prop('required', false);
            $('#date_from_label').html('Start Date <span class="text-danger">*</span>');
            $('#days_required').hide();
            // Uncheck all days for daily (will be ignored)
            $('.bulk-day-checkbox').prop('checked', false);
            
        } else if (patternType === 'weekly') {
            // Weekly: show duration, hide date_to, days required
            $('#recurring_duration_section').show();
            $('#date_to_wrapper').hide();
            $('#bulk_date_to').prop('required', false);
            $('#date_from_label').html('Start Date <span class="text-danger">*</span>');
            $('#days_required').show();
            // Check Mon-Fri by default for weekly
            $('.bulk-day-checkbox').prop('checked', false);
            $('#bulk_day_1, #bulk_day_2, #bulk_day_3, #bulk_day_4, #bulk_day_5').prop('checked', true);
        }

        enforceDurationLimitByUnit();
        
        // Calculate and set date_to based on duration for recurring patterns
        if (patternType !== 'onetime') {
            updateDateTo();
        }
    });

    // Update date_to when duration changes
    $('#duration_value, #duration_unit').change(function() {
        enforceDurationLimitByUnit();
        if ($('#bulkCreateModal input[name="pattern_type"]:checked').val() !== 'onetime') {
            updateDateTo();
        }
    });

    // Update date_to when start date changes for recurring
    $('#bulk_date_from').change(function() {
        if ($('#bulkCreateModal input[name="pattern_type"]:checked').val() !== 'onetime') {
            updateDateTo();
        }
    });

    function enforceDurationLimitByUnit() {
        var durationUnit = $('#duration_unit').val();

        $('#duration_value option').each(function() {
            var value = parseInt($(this).val(), 10);
            var isOverMonthLimit = durationUnit === 'months' && value > 3;
            $(this).prop('disabled', isOverMonthLimit).toggle(!isOverMonthLimit);
        });

        var currentValue = parseInt($('#duration_value').val(), 10);
        if (durationUnit === 'months' && currentValue > 3) {
            $('#duration_value').val('3');
        }

        if (durationUnit === 'months') {
            $('#duration_help_text').text('Monthly recurring slots are limited to 3 months.');
        } else {
            $('#duration_help_text').text('Slots will be created from start date for this duration');
        }
    }

    function updateDateTo() {
        var startDate = $('#bulk_date_from').val();
        if (!startDate) return;
        
        var durationValue = parseInt($('#duration_value').val());
        var durationUnit = $('#duration_unit').val();
        
        var date = new Date(startDate);
        
        if (durationUnit === 'months') {
            date.setMonth(date.getMonth() + durationValue);
        } else if (durationUnit === 'weeks') {
            date.setDate(date.getDate() + (durationValue * 7));
        }
        
        // Format as YYYY-MM-DD
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        var formattedDate = year + '-' + month + '-' + day;
        
        $('#bulk_date_to').val(formattedDate);
    }

    enforceDurationLimitByUnit();

    function loadBlockedDates() {
        $.ajax({
            url: '{{ route("admin.availability.blocked") }}',
            type: 'GET',
            success: function(response) {
                $('#blocked-dates-content').html(response);
            },
            error: function() {
                $('#blocked-dates-content').html('<div class="alert alert-danger">Error loading blocked dates.</div>');
            }
        });
    }

    // Handle remote submit for Unblock in modal
    $(document).on('submit', '.remote-submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');

        // Button feedback
        var btn = form.find('button[type="submit"]');
        var originalBtn = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: url,
            type: method, // POST or PATCH
            data: form.serialize(),
            success: function(response) {
                // Reload the table
                loadBlockedDates();
                
                // Show success toast
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.message || 'Updated successfully');
                }
            },
            error: function() {
                if (typeof toastr !== 'undefined') {
                    toastr.error('An error occurred.');
                }
                btn.prop('disabled', false).html(originalBtn);
            }
        });
    });

    // Auto-open modals on validation error
    @if($errors->any())
        @if(old('date_from'))
            $('#bulkCreateModal').modal('show');
        @else
            $('#createSlotModal').modal('show');
        @endif
    @endif

    var calendarViewInitialized = false;
    var calendar = null;

    function initCalendar() {
        if (!calendarViewInitialized) {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: function(info, successCallback, failureCallback) {
                    var service_id = $('select[name="service_id"]').val();
                    var location_id = $('select[name="location_id"]').val();
                    var instructor_id = $('select[name="instructor_id"]').val();

                    $.ajax({
                        url: '{{ route('admin.availability.calendar.events') }}',
                        data: {
                            start: info.startStr,
                            end: info.endStr,
                            service_id: service_id,
                            location_id: location_id,
                            instructor_id: instructor_id
                        },
                        success: function(events) {
                            successCallback(events);
                        },
                        error: function() {
                            failureCallback();
                        }
                    });
                },
                
                // Tooltip on hover
                eventDidMount: function(info) {
                    tippy(info.el, {
                        content: info.event.extendedProps.tooltip,
                        placement: 'top',
                        allowHTML: false,
                    });
                },

                eventClick: function(info) {
                    var event = info.event;
                    if (confirm('Are you sure you want to delete this availability slot? This action cannot be undone.')) {
                        // Request deletion
                        var url = '{{ route("admin.availability.destroy", ":id") }}';
                        url = url.replace(':id', event.id);

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                alert('Availability slot deleted successfully.');
                                event.remove();
                            },
                            error: function(xhr) {
                                var message = 'An error occurred while deleting the slot.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                alert(message);
                            }
                        });
                    }
                },
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short'
                }
            });
            calendar.render();
            calendarViewInitialized = true;
        } else {
            setTimeout(function(){ calendar.updateSize(); }, 1);
        }
    }

    // Initialize calendar by default
    initCalendar();

    // Bulk Actions
    const selectAll = $('#select-all-slots');
    const slotCheckboxes = '.slot-checkbox';
    const bulkToolbar = $('#bulk-actions-toolbar');
    const selectedCountSpan = $('#selected-count');
    const bulkDeleteBtn = $('#bulk-delete-btn');
    const cancelSelectionBtn = $('#cancel-selection-btn');

    function updateBulkToolbar() {
        const checkedCount = $(slotCheckboxes + ':checked').length;
        selectedCountSpan.text(checkedCount);
        if (checkedCount > 0) {
            bulkToolbar.slideDown();
        } else {
            bulkToolbar.slideUp();
        }
    }

    selectAll.change(function() {
        $(slotCheckboxes).prop('checked', $(this).prop('checked'));
        updateBulkToolbar();
    });

    $(document).on('change', slotCheckboxes, function() {
        updateBulkToolbar();
        // Update select all checkbox state
        const allChecked = $(slotCheckboxes).length === $(slotCheckboxes + ':checked').length;
        selectAll.prop('checked', allChecked);
    });

    cancelSelectionBtn.click(function() {
        $(slotCheckboxes).prop('checked', false);
        selectAll.prop('checked', false);
        updateBulkToolbar();
    });

    bulkDeleteBtn.click(function() {
        const selectedIds = $(slotCheckboxes + ':checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) return;

        if (confirm('Are you sure you want to delete ' + selectedIds.length + ' selected slots?')) {
            const btn = $(this);
            const originalText = btn.html();
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Deleting...');

            $.ajax({
                url: '{{ route("admin.availability.bulk-destroy") }}',
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: selectedIds
                },
                success: function(response) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message);
                    } else {
                        alert(response.message);
                    }
                    // Reload page to refresh list
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('An error occurred while deleting slots.');
                    } else {
                        alert('An error occurred');
                    }
                    btn.prop('disabled', false).html(originalText);
                }
            });
        }
    });

    // Instant Delete
    $('.instant-delete-btn').click(function() {
        const btn = $(this);
        const slotId = btn.data('slot-id');
        const hasBookings = btn.data('has-bookings');

        if (hasBookings) {
            alert('Cannot delete this slot because it has existing bookings.');
            return;
        }

        if (confirm('Are you sure you want to delete this slot instantly?')) {
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: '/admin/availability/' + slotId,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Slot deleted successfully');
                    }
                    // Remove row with animation
                    btn.closest('tr').fadeOut(500, function() {
                        $(this).remove();
                    });
                },
                error: function(xhr) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Failed to delete slot');
                    } else {
                        alert('Failed to delete slot');
                    }
                    btn.prop('disabled', false).html('<i class="fas fa-trash"></i>');
                }
            });
        }
    });

    $('#toggle-view-btn').click(function(e) {
        e.preventDefault();
        var isCalendarVisible = $('#calendar-view-container').is(':visible');

        if (isCalendarVisible) {
            // Switch to List
            $('#calendar-view-container').hide();
            $('#list-view-container').show();
            $(this).html('<i class="fas fa-calendar-alt mr-1"></i>Calendar View');
            $(this).removeClass('btn-info').addClass('btn-secondary');
        } else {
            // Switch to Calendar
            $('#list-view-container').hide();
            $('#calendar-view-container').show();
            $(this).html('<i class="fas fa-list mr-1"></i>List View');
            $(this).removeClass('btn-secondary').addClass('btn-info');
            
            initCalendar();
        }
    });
});
</script>
@stop
