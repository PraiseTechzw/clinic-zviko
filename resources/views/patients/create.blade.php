@extends('layouts.app')

@section('title', 'Register Patient')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-xl-8 mx-auto">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ url('/patients') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold mb-0 text-primary">Patient Registration</h2>
                    <p class="text-muted small">Input essential demographics to onboard a new patient into the system.</p>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4 ps-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ url('/patients') }}" method="POST">
                        @csrf
                        <div class="row g-4 mb-4">
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">First Name</label>
                                <input type="text" name="first_name"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    placeholder="e.g., John" value="{{ old('first_name') }}" required>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Last Name</label>
                                <input type="text" name="last_name"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    placeholder="e.g., Doe" value="{{ old('last_name') }}" required>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Gender Designation</label>
                                <select name="gender"
                                    class="form-select rounded-pill bg-light border-0 px-3 py-2 shadow-none" required>
                                    <option value="" disabled selected>Select gender...</option>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Date of Birth</label>
                                <input type="date" name="date_of_birth"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    value="{{ old('date_of_birth') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-secondary">Primary Contact Number</label>
                            <input type="text" name="phone"
                                class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                placeholder="e.g., +263 77 123 4567" value="{{ old('phone') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-secondary">Residential Address</label>
                            <textarea name="address" class="form-control rounded-4 bg-light border-0 px-3 py-2 shadow-none"
                                rows="3" placeholder="Enter complete home address..."
                                required>{{ old('address') }}</textarea>
                        </div>

                        <div class="d-grid pt-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm py-2">
                                <i class="fas fa-save me-2 small"></i>Register Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection