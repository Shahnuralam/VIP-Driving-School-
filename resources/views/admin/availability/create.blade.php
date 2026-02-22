@extends('adminlte::page')

@section('title', 'Create Availability Slot')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-calendar-plus mr-2"></i>Create Availability Slot</h1>
        <a href="{{ route('admin.availability.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Back
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('admin.availability.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Pattern Type</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="create_pattern_onetime" name="pattern_type" value="onetime" {{ old('pattern_type', 'onetime') === 'onetime' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="create_pattern_onetime">
                                            <strong>One-time</strong><br>
                                            <small class="text-muted">Create single date slots</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="create_pattern_daily" name="pattern_type" value="daily" {{ old('pattern_type') === 'daily' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="create_pattern_daily">
                                            <strong>Every day</strong><br>
                                            <small class="text-muted">Repeat each day</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="create_pattern_weekly" name="pattern_type" value="weekly" {{ old('pattern_type') === 'weekly' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="create_pattern_weekly">
                                            <strong>Weekly</strong><br>
                                            <small class="text-muted">Repeat on selected days</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="create_pattern_monthly" name="pattern_type" value="monthly" {{ old('pattern_type') === 'monthly' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="create_pattern_monthly">
                                            <strong>Monthly</strong><br>
                                            <small class="text-muted">Repeat each month</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="create_recurring_duration_section" class="form-group" style="display: none;">
                            <label>Duration <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="duration_value" id="create_duration_value" class="form-control @error('duration_value') is-invalid @enderror">
                                        @foreach([1, 2, 3, 4, 6, 8, 12] as $durationValue)
                                            <option value="{{ $durationValue }}" {{ (string) old('duration_value', '1') === (string) $durationValue ? 'selected' : '' }}>{{ $durationValue }}</option>
                                        @endforeach
                                    </select>
                                    @error('duration_value')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <select name="duration_unit" id="create_duration_unit" class="form-control @error('duration_unit') is-invalid @enderror">
                                        <option value="weeks" {{ old('duration_unit', 'weeks') === 'weeks' ? 'selected' : '' }}>Weeks</option>
                                        <option value="months" {{ old('duration_unit') === 'months' ? 'selected' : '' }}>Months</option>
                                    </select>
                                    @error('duration_unit')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <small class="text-muted" id="create_duration_help_text">Slots will be created from start date for this duration.</small>
                        </div>

                        <div id="create_days_section" class="form-group" style="display: none;">
                            <label>Days of Week <span class="text-danger">*</span></label>
                            <div class="row">
                                @php
                                    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                    $selectedDays = old('days', [1, 2, 3, 4, 5]);
                                @endphp
                                @foreach($days as $index => $day)
                                    <div class="col-md-3 col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input create-day-checkbox" id="create_day_{{ $index }}" name="days[]" value="{{ $index }}" {{ in_array($index, (array) $selectedDays) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="create_day_{{ $index }}">{{ $day }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('days')
                                <span class="text-danger d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Service (Optional)</label>
                            <select name="service_id" class="form-control select2">
                                <option value="">All Services</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Leave empty to make this slot available for all services.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Location (Optional)</label>
                            <select name="location_id" class="form-control select2">
                                <option value="">All Locations</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Leave empty to make this slot available for all locations.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Instructor(s) (Optional)</label>
                            <select name="instructor_ids[]" class="form-control select2" multiple="multiple">
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" {{ (collect(old('instructor_ids'))->contains($instructor->id)) ? 'selected' : '' }}>
                                        {{ $instructor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Leave empty for Global Availability (fallback when no specific instructor slot exists).</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label id="create_date_label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="create_date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Start Time <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', '09:00') }}" required>
                            @error('start_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>End Time <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', '10:00') }}" required>
                            @error('end_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Max Bookings <span class="text-danger">*</span></label>
                            <input type="number" name="max_bookings" class="form-control @error('max_bookings') is-invalid @enderror" value="{{ old('max_bookings', 1) }}" min="1" required>
                            @error('max_bookings')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Number of bookings allowed for this time slot.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" id="is_available" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_available">Available for Booking</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Any additional notes about this slot...">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>Create Slot(s)
                </button>
                <a href="{{ route('admin.availability.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
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

    function enforceCreateDurationLimitByUnit() {
        const patternType = $('input[name="pattern_type"]:checked').val() || 'onetime';
        const durationUnitSelect = $('#create_duration_unit');
        const durationValueSelect = $('#create_duration_value');
        const weeksOption = durationUnitSelect.find('option[value="weeks"]');

        if (patternType === 'monthly') {
            weeksOption.prop('disabled', true);
            durationUnitSelect.val('months');
        } else {
            weeksOption.prop('disabled', false);
        }

        const durationUnit = durationUnitSelect.val();
        durationValueSelect.find('option').each(function() {
            const optionValue = parseInt($(this).val(), 10);
            const exceedsMonthLimit = durationUnit === 'months' && optionValue > 3;
            $(this).prop('disabled', exceedsMonthLimit).toggle(!exceedsMonthLimit);
        });

        const currentValue = parseInt(durationValueSelect.val(), 10);
        if (durationUnit === 'months' && currentValue > 3) {
            durationValueSelect.val('3');
        }

        if (durationUnit === 'months') {
            $('#create_duration_help_text').text('When unit is months, maximum duration is 3 months.');
        } else if (patternType === 'monthly') {
            $('#create_duration_help_text').text('Monthly pattern repeats on the same calendar day each month.');
        } else {
            $('#create_duration_help_text').text('Slots will be created from start date for this duration.');
        }
    }

    function updateCreatePatternUI() {
        const patternType = $('input[name="pattern_type"]:checked').val() || 'onetime';
        const isRecurring = patternType !== 'onetime';
        const isWeekly = patternType === 'weekly';

        $('#create_recurring_duration_section').toggle(isRecurring);
        $('#create_days_section').toggle(isWeekly);

        if (isRecurring) {
            $('#create_date_label').html('Start Date <span class="text-danger">*</span>');
        } else {
            $('#create_date_label').html('Date <span class="text-danger">*</span>');
        }

        enforceCreateDurationLimitByUnit();
    }

    $('input[name="pattern_type"]').on('change', updateCreatePatternUI);
    $('#create_duration_unit, #create_duration_value').on('change', enforceCreateDurationLimitByUnit);

    updateCreatePatternUI();
});
</script>
@stop
