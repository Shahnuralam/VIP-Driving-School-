@extends('adminlte::page')

@section('title', 'Add User')

@section('content_header')
    <h1>Add New User</h1>
@stop

@section('content')
<div class="card">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="Enter full name" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" placeholder="Enter email address" required>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone') }}" placeholder="Enter phone number">
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Enter password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control" placeholder="Confirm password" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                            <option value="">Select Role</option>
                            <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Active Account</label>
                        </div>
                        <small class="text-muted">Inactive users cannot log in</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Role Permissions</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Permission</th>
                    <th class="text-center">Super Admin</th>
                    <th class="text-center">Administrator</th>
                    <th class="text-center">Staff</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Manage Users</td>
                    <td class="text-center text-success"><i class="fas fa-check"></i></td>
                    <td class="text-center text-danger"><i class="fas fa-times"></i></td>
                    <td class="text-center text-danger"><i class="fas fa-times"></i></td>
                </tr>
                <tr>
                    <td>System Settings</td>
                    <td class="text-center text-success"><i class="fas fa-check"></i></td>
                    <td class="text-center text-danger"><i class="fas fa-times"></i></td>
                    <td class="text-center text-danger"><i class="fas fa-times"></i></td>
                </tr>
                <tr>
                    <td>Manage Content</td>
                    <td class="text-center text-success"><i class="fas fa-check"></i></td>
                    <td class="text-center text-success"><i class="fas fa-check"></i></td>
                    <td class="text-center text-danger"><i class="fas fa-times"></i></td>
                </tr>
                <tr>
                    <td>Manage Bookings</td>
                    <td class="text-center text-success"><i class="fas fa-check"></i></td>
                    <td class="text-center text-success"><i class="fas fa-check"></i></td>
                    <td class="text-center text-success"><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td>View Reports</td>
                    <td class="text-center text-success"><i class="fas fa-check"></i></td>
                    <td class="text-center text-success"><i class="fas fa-check"></i></td>
                    <td class="text-center text-warning"><i class="fas fa-minus"></i></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop
