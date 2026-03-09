@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-primary">Physician Workspace</h2>
            <p class="text-muted small">Daily schedule and patient consultation overview.</p>
        </div>
        <div class="text-end">
            <h6 class="fw-bold mb-0">{{ now()->format('l, jS M Y') }}</h6>
            <small class="badge bg-light text-primary border px-3 mt-1 shadow-sm">Online & Active</small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 ps-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4">Time Entry</th>
                            <th>Patient Information</th>
                            <th class="text-center">Status</th>
                            <th>Initial Intake Notes</th>
                            <th class="text-end pe-4">Consultation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appt)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark fs-5">{{ $appt->appointment_date->format('H:i') }}</div>
                                    <small
                                        class="text-muted text-uppercase fw-bold ls-1 small-xs">{{ $appt->appointment_date->format('A') }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center py-2">
                                        <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                            style="width: 38px; height: 38px;">
                                            <i class="fas fa-user-circle text-secondary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $appt->patient->full_name }}</h6>
                                            <small class="text-muted">{{ $appt->patient->gender }},
                                                {{ \Carbon\Carbon::parse($appt->patient->date_of_birth)->age }} Years</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge rounded-pill bg-{{ $appt->status === 'Scheduled' ? 'primary' : 'warning' }} bg-opacity-10 text-{{ $appt->status === 'Scheduled' ? 'primary' : 'warning' }} px-3 px-2 border-0">
                                        {{ $appt->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small text-muted text-truncate" style="max-width: 200px;">
                                        {{ $appt->notes ?: 'No initial intake notes provided.' }}
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ url('/doctor/consultation/' . $appt->patient->id) }}"
                                        class="btn btn-success btn-sm rounded-pill px-4 py-2 shadow-sm border-0 d-inline-flex align-items-center">
                                        <i class="fas fa-stethoscope me-2 small"></i>
                                        <span>Begin Session</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="opacity-25 mb-3">
                                        <i class="fas fa-notes-medical display-1"></i>
                                    </div>
                                    <h5 class="text-muted fw-bold">No Pending Appointments</h5>
                                    <p class="text-muted small">Your current schedule for today is completely clear.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<style>
    .ls-1 {
        letter-spacing: 1px;
    }

    .small-xs {
        font-size: 0.7rem;
    }
</style>