@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="d-flex align-items-center mb-5">
                <div class="p-3 bg-white rounded-circle shadow-sm me-4">
                    <i class="fas fa-cogs text-primary fa-2x"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0">Clinic System Configuration</h2>
                    <p class="text-muted small">Manage global organization parameters and system-wide defaults.</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Branding Card -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="card-header bg-white py-4 border-0 ps-4">
                            <h5 class="fw-bold mb-0">Branding & Contact Info</h5>
                        </div>
                        <div class="card-body p-4 pt-0">
                            <form action="{{ url('/admin/settings') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-secondary">Clinic Formal Name</label>
                                    <input type="text" name="clinic_name"
                                        class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                        value="{{ old('clinic_name', $settings['clinic_name']) }}" required>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6 mt-0">
                                        <label class="form-label fw-bold small text-secondary">Organization Email</label>
                                        <input type="email" name="clinic_email"
                                            class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                            value="{{ old('clinic_email', $settings['clinic_email']) }}" required>
                                    </div>
                                    <div class="col-md-6 mt-0">
                                        <label class="form-label fw-bold small text-secondary">Primary Phone Line</label>
                                        <input type="text" name="clinic_phone"
                                            class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                            value="{{ old('clinic_phone', $settings['clinic_phone']) }}" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-secondary">Clinic HQ Address</label>
                                    <textarea name="clinic_address"
                                        class="form-control rounded-4 bg-light border-0 px-3 py-2 shadow-none" rows="3"
                                        required>{{ old('clinic_address', $settings['clinic_address']) }}</textarea>
                                </div>

                                <div class="d-grid mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                        <i class="fas fa-save me-2 small"></i>Deploy Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Guidance & Context -->
                <div class="col-md-5">
                    <div class="card border-0 bg-dark rounded-4 h-100 p-3 shadow-lg">
                        <div class="card-body text-white">
                            <h5 class="fw-bold mb-4 text-warning"><i class="fas fa-info-circle me-3"></i>Configuration Guide
                            </h5>

                            <div class="d-flex mb-4">
                                <div class="me-3 p-1"><i class="fas fa-check-circle text-success mt-1"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Clinic Name</h6>
                                    <small class="text-white text-opacity-75">Visible on all reports, invoices, and system
                                        exports.</small>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="me-3 p-1"><i class="fas fa-check-circle text-success mt-1"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Contact Details</h6>
                                    <small class="text-white text-opacity-75">Used for system notification headers and
                                        footer information on patient documents.</small>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="me-3 p-1"><i class="fas fa-check-circle text-success mt-1"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Real-time Updates</h6>
                                    <small class="text-white text-opacity-75">Settings take effect immediately upon
                                        deployment to the production environment.</small>
                                </div>
                            </div>

                            <div class="bg-white bg-opacity-10 p-3 rounded-4 mt-5">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-shield-alt text-warning me-3 fa-lg"></i>
                                    <small class="text-white text-opacity-75">Admin restricted area. Changes are logged for
                                        audit purposes.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection