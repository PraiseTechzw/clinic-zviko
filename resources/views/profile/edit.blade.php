@extends('layouts.app')

@section('title', 'Manage Profile')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-user-circle fa-2x text-primary me-3"></i>
                <div>
                    <h2 class="fw-bold mb-0">My Security Profile</h2>
                    <p class="text-muted small">Update your account credentials and personal information.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ url('/profile') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Display Name</label>
                                <input type="text" name="name"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Email Account</label>
                                <input type="email" name="email"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <hr class="my-4 opacity-10">

                            <div class="col-12 mt-0">
                                <h6 class="fw-bold mb-3"><i class="fas fa-key me-2 small"></i>Change Password</h6>
                                <p class="text-muted small mb-4">Leave these fields blank if you do not want to change your
                                    current password.</p>
                            </div>

                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">New Secure Password</label>
                                <input type="password" name="password"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    placeholder="Enter new password (optional)">
                            </div>
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Verify New Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    placeholder="Confirm new password">
                            </div>

                            <div class="col-12 mt-5 text-end">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                                    <i class="fas fa-save me-2 small"></i>Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Role Information Card -->
            <div class="card border-0 bg-primary bg-opacity-10 rounded-4">
                <div class="card-body d-flex align-items-center py-4">
                    <div class="p-3 bg-white rounded-circle me-4 shadow-sm">
                        <i class="fas fa-shield-alt text-primary fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Current Access Level: {{ ucfirst($user->role) }}</h6>
                        <p class="text-muted small mb-0">Your permissions are managed by the lead administrator. Contact
                            support for role adjustments.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection