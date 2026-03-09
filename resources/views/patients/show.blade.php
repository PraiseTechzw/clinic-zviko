@extends('layouts.app')

@section('title', 'Patient Full Case File')

@section('content')
    <div class="row align-items-center mb-5">
        <div class="col-auto">
            <a href="{{ url('/patients') }}"
                class="btn btn-outline-secondary border-0 bg-transparent rounded-pill px-3 py-1">
                <i class="fas fa-arrow-left me-2"></i>Back to Census
            </a>
        </div>
        <div class="col">
            <h2 class="fw-bold mb-0 text-dark">Patient Record: <span class="text-primary">{{ $patient->full_name }}</span>
            </h2>
            <p class="text-muted small mb-0">System Identifier: #{{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }} |
                Registered {{ $patient->created_at->format('M d, Y') }}</p>
        </div>
        <div class="col-auto">
            <a href="{{ url('/patients/' . $patient->id . '/edit') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-edit me-2"></i>Edit Case Data
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Demographics Column -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center overflow-hidden mb-4">
                <div class="p-5" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="avatar-xl rounded-circle bg-white p-3 d-inline-block shadow">
                        <i class="fas fa-user-injured fa-4x text-primary"></i>
                    </div>
                </div>
                <div class="card-body px-4 pt-0 pb-5" style="margin-top: -30px;">
                    <div class="bg-white rounded-circle p-1 d-inline-block mb-3">
                        <span
                            class="badge rounded-pill bg-{{ $patient->gender === 'Male' ? 'primary' : 'danger' }} px-4 py-2 fs-6">
                            {{ $patient->gender }}
                        </span>
                    </div>
                    <h4 class="fw-bold text-dark">{{ $patient->full_name }}</h4>
                    <p class="text-secondary small fw-bold text-uppercase ls-1">Date of Birth:
                        {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</p>
                    <div class="row mt-4">
                        <div class="col-6 border-end">
                            <h4 class="fw-bold text-primary mb-0">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}
                            </h4>
                            <small class="text-muted text-uppercase fw-bold ls-1 small-xs">Years Old</small>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-bold text-success mb-0">{{ $patient->medicalRecords->count() }}</h4>
                            <small class="text-muted text-uppercase fw-bold ls-1 small-xs">Treatments</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-4 text-secondary"><i class="fas fa-address-book me-3 text-primary"></i>Contact
                    Intelligence</h6>
                <div class="d-flex mb-4">
                    <div class="p-2 bg-light rounded-circle me-3"><i class="fas fa-phone text-muted small"></i></div>
                    <div>
                        <small class="text-muted d-block small-xs">Primary Line</small>
                        <span class="fw-bold text-dark">{{ $patient->phone }}</span>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="p-2 bg-light rounded-circle me-3"><i class="fas fa-map-marker-alt text-muted small"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block small-xs">Residence</small>
                        <span class="fw-bold text-dark small">{{ $patient->address }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- History/Timeline Column -->
        <div class="col-lg-8">
            <!-- Medical Record History -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-4 ps-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Clinical History Pool</h5>
                    <span
                        class="badge bg-light text-dark px-3 py-2 border rounded-pill">{{ $patient->medicalRecords->count() }}
                        Historic Visits</span>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="timeline ps-3 border-start">
                        @forelse($patient->medicalRecords as $record)
                            <div class="timeline-item mb-5 ps-4 position-relative">
                                <span class="timeline-marker bg-primary position-absolute"></span>
                                <div class="p-4 bg-light rounded-4 border-0 shadow-sm transition-all hover-transform">
                                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                                        <div class="fw-bold text-primary">{{ $record->visit_date->format('M d, Y') }}</div>
                                        <div class="small fw-bold text-dark"><i class="fas fa-user-md me-2 text-primary"></i>Dr.
                                            {{ $record->doctor->user->name }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-uppercase fw-bold ls-1 text-secondary small-xs">Diagnostic
                                            Assessment</small>
                                        <div class="text-dark fw-bold fs-6">{{ $record->diagnosis }}</div>
                                    </div>
                                    <div>
                                        <small class="text-uppercase fw-bold ls-1 text-secondary small-xs">Clinical Plan &
                                            Prescriptions</small>
                                        <div class="text-muted small lh-lg">{{ $record->treatment }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-5 text-center">
                                <i class="fas fa-notes-medical display-4 d-block mb-3 opacity-25"></i>
                                <h6 class="text-muted">No historical clinical data found on this profile.</h6>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Appointment Log -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-4 ps-4 border-0">
                    <h5 class="fw-bold mb-0">Unified Visitation Schedule</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Timestamp</th>
                                    <th>Practitioner</th>
                                    <th class="text-center">Lifecycle Status</th>
                                    <th class="text-end pe-4">Clinical Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patient->appointments as $appt)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $appt->appointment_date->format('M d, Y') }}</div>
                                            <small
                                                class="text-muted small-xs">{{ $appt->appointment_date->format('h:i A') }}</small>
                                        </td>
                                        <td>Dr. {{ $appt->doctor->user->name }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge rounded-pill bg-{{ $appt->status === 'Scheduled' ? 'primary' : ($appt->status === 'Completed' ? 'success' : 'danger') }} bg-opacity-10 text-{{ $appt->status === 'Scheduled' ? 'primary' : ($appt->status === 'Completed' ? 'success' : 'danger') }} px-3 border-0">
                                                {{ $appt->status }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="small text-muted text-truncate" style="max-width: 150px;">
                                                {{ $appt->notes ?: '---' }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .ls-1 {
        letter-spacing: 1px;
    }

    .small-xs {
        font-size: 0.75rem;
    }

    .avatar-xl {
        width: 120px;
        height: 120px;
    }

    .timeline {
        border-width: 2px !important;
    }

    .timeline-marker {
        width: 14px;
        height: 14px;
        left: -32px;
        top: 30px;
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 2px #667eea;
    }

    .hover-transform:hover {
        transform: translateX(10px);
    }

    .transition-all {
        transition: all 0.3s ease;
    }
</style>