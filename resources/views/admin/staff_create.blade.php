@extends('layouts.app')

@section('title', 'Add Staff Member')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8 col-xl-6 mx-auto">
                <div class="d-flex align-items-center mb-4 text-primary">
                    <a href="{{ url('/admin/staff') }}" class="btn btn-sm btn-outline-primary border-0 bg-transparent me-2">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h3 class="fw-bold mb-0">Add New Staff Member</h3>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <form action="{{ url('/admin/staff') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control rounded-pill @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control rounded-pill @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input type="password"
                                    class="form-control rounded-pill @error('password') is-invalid @enderror" id="password"
                                    name="password" required>
                                @error('password') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                                <small class="text-muted ps-2">Minimum 6 characters recommended.</small>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label fw-bold">Role</label>
                                <select class="form-select rounded-pill @error('role') is-invalid @enderror" id="role"
                                    name="role" required>
                                    <option value="" disabled selected>Select Role</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator
                                    </option>
                                    <option value="doctor" {{ old('role') === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                    <option value="receptionist" {{ old('role') === 'receptionist' ? 'selected' : '' }}>
                                        Receptionist</option>
                                </select>
                                @error('role') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
                            </div>

                            <div id="specialization-field" class="mb-4 d-none">
                                <label for="specialization" class="form-label fw-bold">Specialization</label>
                                <input type="text" class="form-control rounded-pill" name="specialization"
                                    placeholder="e.g., General Physician, Dentist, Cardiologist"
                                    value="{{ old('specialization') }}">
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">Save Staff
                                    Member</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSpecialization() {
            var roleSelect = document.getElementById('role');
            var specializationField = document.getElementById('specialization-field');
            if (roleSelect.value === 'doctor') {
                specializationField.classList.remove('d-none');
            } else {
                specializationField.classList.add('d-none');
            }
        }

        document.getElementById('role').addEventListener('change', toggleSpecialization);
        document.addEventListener('DOMContentLoaded', toggleSpecialization);
    </script>
@endsection