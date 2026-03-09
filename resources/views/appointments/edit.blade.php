@extends('layouts.app')

@section('title', 'Edit Appointment')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-xl-6 mx-auto">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <a href="{{ url('/appointments') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h4 class="fw-bold mb-0">Edit Appointment</h4>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm border-0 rounded-3">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/appointments/' . $appointment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="patient_id" class="form-label fw-bold small">Patient</label>
                            <select class="form-select rounded- pill bg-light border-0 px-3" name="patient_id" required>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ (old('patient_id') ?? $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="doctor_id" class="form-label fw-bold small">Doctor</label>
                            <select class="form-select rounded-pill bg-light border-0 px-3" name="doctor_id" required>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ (old('doctor_id') ?? $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        Dr. {{ $doctor->user->name }} ({{ $doctor->specialization }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="appointment_date" class="form-label fw-bold small">Date & Time</label>
                            <input type="datetime-local"
                                class="form-control rounded-pill bg-light border-0 px-3 shadow-none" name="appointment_date"
                                value="{{ old('appointment_date', \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i')) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold small">Status</label>
                            <select class="form-select rounded-pill bg-light border-0 px-3" name="status" required>
                                <option value="Scheduled" {{ (old('status') ?? $appointment->status) == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="Rescheduled" {{ (old('status') ?? $appointment->status) == 'Rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                                <option value="Cancelled" {{ (old('status') ?? $appointment->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="Completed" {{ (old('status') ?? $appointment->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold small">Initial Notes</label>
                            <textarea class="form-control rounded-4 bg-light border-0" name="notes"
                                rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">Update
                                Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection