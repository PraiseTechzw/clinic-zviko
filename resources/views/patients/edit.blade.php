@extends('layouts.app')

@section('title', 'Edit Patient Profile')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-xl-6 mx-auto">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ url('/patients/' . $patient->id) }}"
                    class="btn btn-outline-secondary btn-sm rounded-circle me-3 border-0 bg-transparent">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h3 class="fw-bold mb-0">Update Patient Profile</h3>
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

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="p-1" style="background: linear-gradient(90deg, #4e54c8, #8f94fb);"></div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ url('/patients/' . $patient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-4 mb-4">
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">First Name</label>
                                <input type="text" name="first_name"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    value="{{ old('first_name', $patient->first_name) }}" required>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Last Name</label>
                                <input type="text" name="last_name"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    value="{{ old('last_name', $patient->last_name) }}" required>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Gender Designation</label>
                                <select name="gender"
                                    class="form-select rounded-pill bg-light border-0 px-3 py-2 shadow-none" required>
                                    <option value="Male" {{ old('gender', $patient->gender) === 'Male' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="Female" {{ old('gender', $patient->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $patient->gender) === 'Other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Date of Birth</label>
                                <input type="date" name="date_of_birth"
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                    value="{{ old('date_of_birth', $patient->date_of_birth) }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-secondary">Phone Number</label>
                            <input type="text" name="phone"
                                class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none"
                                value="{{ old('phone', $patient->phone) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-secondary">Address</label>
                            <textarea name="address" class="form-control rounded-4 bg-light border-0 px-3 py-2 shadow-none"
                                rows="3" required>{{ old('address', $patient->address) }}</textarea>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="fas fa-save me-2 small"></i>Update Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection