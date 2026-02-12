@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User: {{ $user->name }}</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name) }}" placeholder="Enter full name" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" placeholder="Enter email address" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $user->phone) }}" placeholder="Enter phone number">
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Leave blank to keep current password">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Minimum 8 characters. Leave empty to keep current password.</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control" placeholder="Confirm new password">
                    </div>

                    <div class="form-group">
                        <label for="role">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required 
                                {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <option value="">Select Role</option>
                            <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @if($user->id === auth()->id())
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            <small class="text-warning">You cannot change your own role</small>
                        @endif
                        @error('role')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <label class="custom-control-label" for="is_active">Active Account</label>
                        </div>
                        @if($user->id === auth()->id())
                            <input type="hidden" name="is_active" value="1">
                            <small class="text-warning">You cannot deactivate your own account</small>
                        @else
                            <small class="text-muted">Inactive users cannot log in</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-dark">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-clock mr-2"></i>Account Info</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted" width="40%">Account Created</td>
                        <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Last Updated</td>
                        <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Email Verified</td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="text-success"><i class="fas fa-check-circle mr-1"></i>{{ $user->email_verified_at->format('M d, Y') }}</span>
                            @else
                                <span class="text-warning"><i class="fas fa-exclamation-circle mr-1"></i>Not verified</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Current Role</td>
                        <td><span class="badge badge-{{ $user->role_badge }}">{{ $user->role_display }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Role Permissions</h3>
            </div>
            <div class="card-body">
                @if($user->role === 'super_admin')
                    <p class="mb-2"><i class="fas fa-check text-success mr-2"></i>Full system access</p>
                    <p class="mb-2"><i class="fas fa-check text-success mr-2"></i>Manage all users</p>
                    <p class="mb-2"><i class="fas fa-check text-success mr-2"></i>System settings</p>
                    <p class="mb-0"><i class="fas fa-check text-success mr-2"></i>All content & bookings</p>
                @elseif($user->role === 'admin')
                    <p class="mb-2"><i class="fas fa-check text-success mr-2"></i>Manage content</p>
                    <p class="mb-2"><i class="fas fa-check text-success mr-2"></i>Manage bookings</p>
                    <p class="mb-2"><i class="fas fa-check text-success mr-2"></i>View reports</p>
                    <p class="mb-0"><i class="fas fa-times text-danger mr-2"></i>Cannot manage users</p>
                @else
                    <p class="mb-2"><i class="fas fa-check text-success mr-2"></i>View & manage bookings</p>
                    <p class="mb-2"><i class="fas fa-minus text-warning mr-2"></i>Limited reports access</p>
                    <p class="mb-2"><i class="fas fa-times text-danger mr-2"></i>Cannot manage content</p>
                    <p class="mb-0"><i class="fas fa-times text-danger mr-2"></i>Cannot manage users</p>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
