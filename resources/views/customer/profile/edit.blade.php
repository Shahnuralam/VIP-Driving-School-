@extends('customer.layouts.app')

@section('title', 'My Profile')

@section('content')
<h4 class="mb-4"><i class="fas fa-user me-2"></i>My Profile</h4>

<div class="row g-4">
    <!-- Profile Photo -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $customer->getProfilePhotoUrl() }}" alt="{{ $customer->name }}" 
                     class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h5>{{ $customer->name }}</h5>
                <p class="text-muted">{{ $customer->email }}</p>
                
                <form action="{{ route('customer.profile.photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="profile_photo" id="profile_photo" class="form-control form-control-sm" accept="image/*">
                        @error('profile_photo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-camera me-1"></i>Update Photo
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-start">
                    <p class="mb-2"><i class="fas fa-calendar-check text-primary me-2"></i>Member since {{ $customer->created_at->format('M Y') }}</p>
                    <p class="mb-0"><i class="fas fa-clock text-primary me-2"></i>Last login {{ $customer->last_login_at ? $customer->last_login_at->diffForHumans() : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </div>
            <div class="card-body">
                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $customer->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="{{ $customer->email }}" disabled>
                            <small class="text-muted">Email cannot be changed</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $customer->phone) }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   value="{{ old('date_of_birth', $customer->date_of_birth?->format('Y-m-d')) }}">
                            @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="license_number" class="form-label">License Number</label>
                            <input type="text" name="license_number" id="license_number" class="form-control @error('license_number') is-invalid @enderror" 
                                   value="{{ old('license_number', $customer->license_number) }}">
                            @error('license_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="preferred_transmission" class="form-label">Preferred Transmission</label>
                            <select name="preferred_transmission" id="preferred_transmission" class="form-select">
                                <option value="auto" {{ old('preferred_transmission', $customer->preferred_transmission) === 'auto' ? 'selected' : '' }}>Automatic</option>
                                <option value="manual" {{ old('preferred_transmission', $customer->preferred_transmission) === 'manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                                   value="{{ old('address', $customer->address) }}">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="suburb" class="form-label">Suburb</label>
                            <input type="text" name="suburb" id="suburb" class="form-control @error('suburb') is-invalid @enderror" 
                                   value="{{ old('suburb', $customer->suburb) }}">
                            @error('suburb')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="postcode" class="form-label">Postcode</label>
                            <input type="text" name="postcode" id="postcode" class="form-control @error('postcode') is-invalid @enderror" 
                                   value="{{ old('postcode', $customer->postcode) }}">
                            @error('postcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">Notification Preferences</h6>

                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="email_notifications" id="email_notifications" class="form-check-input" value="1"
                               {{ old('email_notifications', $customer->email_notifications) ? 'checked' : '' }}>
                        <label class="form-check-label" for="email_notifications">
                            Email Notifications
                            <small class="text-muted d-block">Receive booking confirmations and reminders via email</small>
                        </label>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="sms_notifications" id="sms_notifications" class="form-check-input" value="1"
                               {{ old('sms_notifications', $customer->sms_notifications) ? 'checked' : '' }}>
                        <label class="form-check-label" for="sms_notifications">
                            SMS Notifications
                            <small class="text-muted d-block">Receive booking reminders via SMS</small>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
