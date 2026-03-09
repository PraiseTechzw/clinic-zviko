@extends('layouts.app')

@section('title', 'Edit Staff Member')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-xl-6 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <a href="{{ url('/admin/staff') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h4 class="fw-bold mb-0">Edit Staff Member</h4>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/admin/staff/' . $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold small">Full Name</label>
                            <input type="text" class="form-control rounded-pill px-3" name="name"
                                value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold small">Email Address</label>
                            <input type="email" class="form-control rounded-pill px-3" name="email"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold small">Role</label>
                            <select class="form-select rounded-pill px-3" id="role-edit" name="role" required>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    Administrator</option>
                                <option value="doctor" {{ old('role', $user->role) === 'doctor' ? 'selected' : '' }}>Doctor
                                </option>
                                <option value="receptionist" {{ old('role', $user->role) === 'receptionist' ? 'selected' : '' }}>Receptionist</option>
                            </select>
                        </div>

                        <div id="specialization-field-edit"
                            class="mb-4 {{ old('role', $user->role) === 'doctor' ? '' : 'd-none' }}">
                            <label class="form-label fw-bold small">Specialization</label>
                            <input type="text" class="form-control rounded-pill px-3 shadow-none" name="specialization"
                                placeholder="e.g., General Physician, Dentist, Cardiologist"
                                value="{{ old('specialization', $user->doctor->specialization ?? '') }}">
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSpecializationEdit() {
            var roleSelect = document.getElementById('role-edit');
            var specializationField = document.getElementById('specialization-field-edit');
            if (roleSelect.value === 'doctor') {
                specializationField.classList.remove('d-none');
            } else {
                specializationField.classList.add('d-none');
            }
        }

        document.getElementById('role-edit').addEventListener('change', toggleSpecializationEdit);
        document.addEventListener('DOMContentLoaded', toggleSpecializationEdit);
    </script>
@endsection