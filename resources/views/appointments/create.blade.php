@extends('layouts.app')

@section('title', 'Schedule Appointment')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-xl-8 mx-auto">
            <div class="d-flex align-items-center mb-5">
                <a href="{{ url('/appointments') }}" class="btn btn-outline-secondary btn-sm rounded-circle me-3 border-0 bg-light shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold mb-0 text-primary">New Appointment Scheduling</h2>
                    <p class="text-muted small">Coordinate clinic timing and medical availability for a patient.</p>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger shadow-sm border-0 rounded-4 mb-4 ps-4">
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-5 overflow-hidden">
                <div class="p-1" style="background: linear-gradient(90deg, #1d976c, #93f9b9);"></div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ url('/appointments') }}" method="POST">
                        @csrf
                        <div class="row g-4 mb-5">
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Target Patient</label>
                                <select name="patient_id" class="form-select rounded-pill bg-light border-0 px-3 py-2 shadow-none" required>
                                    <option value="" disabled selected>-- Choose Patient Profile --</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->full_name }} ({{ $patient->phone }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Clinical Practitioner</label>
                                <select name="doctor_id" class="form-select rounded-pill bg-light border-0 px-3 py-2 shadow-none" required>
                                    <option value="" disabled selected>-- Assign Doctor --</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            Dr. {{ $doctor->user->name }} ({{ $doctor->specialization }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Visitation Timestamp</label>
                                <input type="datetime-local" name="appointment_date" 
                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none" 
                                    value="{{ old('appointment_date') }}" required>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label class="form-label fw-bold small text-secondary">Initial Case Summary</label>
                                <input type="text" name="notes" class="form-control rounded-pill bg-light border-0 px-3 py-2 shadow-none" 
                                    placeholder="Brief reason for visit..." value="{{ old('notes') }}">
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm py-3 fw-bold">
                                <i class="fas fa-calendar-check me-2"></i>Finalize Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Guidance Section -->
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-4 text-center border">
                        <i class="fas fa-clock text-primary mb-2 fa-lg"></i>
                        <h6 class="fw-bold mb-1">Time Sync</h6>
                        <small class="text-muted small-xs">Ensure local time parity with practitioner availability.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-success bg-opacity-10 rounded-4 text-center border">
                        <i class="fas fa-user-shield text-success mb-2 fa-lg"></i>
                        <h6 class="fw-bold mb-1">Privacy First</h6>
                        <small class="text-muted small-xs">Patient records are handled under strict confidentiality protocols.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-info bg-opacity-10 rounded-4 text-center border">
                        <i class="fas fa-file-medical text-info mb-2 fa-lg"></i>
                        <h6 class="fw-bold mb-1">Data Log</h6>
                        <small class="text-muted small-xs">Automated entry creation in the clinical database upon booking.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .small-xs { font-size: 0.72rem; }
</style>