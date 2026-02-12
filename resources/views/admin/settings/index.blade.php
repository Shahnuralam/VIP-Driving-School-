@extends('adminlte::page')

@section('title', 'Settings')

@section('content_header')
    <h1><i class="fas fa-cogs mr-2"></i>Site Settings</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <!-- General Settings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-globe mr-2"></i>General Settings</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Name</label>
                            <input type="text" name="settings[site_name]" class="form-control" value="{{ $settings['site_name'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Tagline</label>
                            <input type="text" name="settings[site_tagline]" class="form-control" value="{{ $settings['site_tagline'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Settings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-address-book mr-2"></i>Contact Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact Email</label>
                            <input type="email" name="settings[contact_email]" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact Phone</label>
                            <input type="text" name="settings[contact_phone]" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Admin Email (for notifications)</label>
                            <input type="email" name="settings[admin_email]" class="form-control" value="{{ $settings['admin_email'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Business Address</label>
                            <input type="text" name="settings[business_address]" class="form-control" value="{{ $settings['business_address'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-share-alt mr-2"></i>Social Media</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fab fa-facebook text-primary mr-1"></i>Facebook URL</label>
                            <input type="url" name="settings[facebook_url]" class="form-control" value="{{ $settings['facebook_url'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fab fa-instagram text-danger mr-1"></i>Instagram URL</label>
                            <input type="url" name="settings[instagram_url]" class="form-control" value="{{ $settings['instagram_url'] ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fab fa-google text-info mr-1"></i>Google Business URL</label>
                            <input type="url" name="settings[google_url]" class="form-control" value="{{ $settings['google_url'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Business Hours -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Business Hours</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Weekdays (Mon-Fri)</label>
                            <input type="text" name="settings[business_hours_weekday]" class="form-control" value="{{ $settings['business_hours_weekday'] ?? '' }}" placeholder="8:00 AM - 6:00 PM">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Saturday</label>
                            <input type="text" name="settings[business_hours_saturday]" class="form-control" value="{{ $settings['business_hours_saturday'] ?? '' }}" placeholder="8:00 AM - 4:00 PM">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sunday</label>
                            <input type="text" name="settings[business_hours_sunday]" class="form-control" value="{{ $settings['business_hours_sunday'] ?? '' }}" placeholder="Closed">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Settings -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check mr-2"></i>Booking Settings</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Advance Booking Days</label>
                            <input type="number" name="settings[booking_advance_days]" class="form-control" value="{{ $settings['booking_advance_days'] ?? '30' }}" min="1">
                            <small class="form-text text-muted">How many days in advance customers can book</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cancellation Notice (hours)</label>
                            <input type="number" name="settings[cancellation_notice_hours]" class="form-control" value="{{ $settings['cancellation_notice_hours'] ?? '24' }}" min="1">
                            <small class="form-text text-muted">Minimum notice required for cancellations</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>Save Settings
            </button>
        </div>
    </form>

    <!-- Stripe Settings Link -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title"><i class="fab fa-stripe mr-2"></i>Payment Settings</h3>
        </div>
        <div class="card-body">
            <p>Configure Stripe payment gateway settings for online bookings.</p>
            <a href="{{ route('admin.settings.stripe') }}" class="btn btn-info">
                <i class="fas fa-credit-card mr-1"></i>Configure Stripe
            </a>
        </div>
    </div>
@stop
