@extends('layouts.app')

@section('title', 'Patient Profile')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Patient Profile</h2>
        <div>
            <a href="/patients/{{ $patient->id }}/edit" class="btn btn-primary"><i class="fas fa-edit me-2"></i>Edit
                Profile</a>
            <a href="/patients" class="btn btn-outline-secondary">Back to List</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Demographics</div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="p-4 bg-light rounded-circle d-inline-block">
                            <i class="fas fa-user fa-4x text-muted"></i>
                        </div>
                        <h4 class="mt-3 fw-bold">{{ $patient->full_name }}</h4>
                        <span class="badge bg-info">{{ $patient->gender }}</span>
                    </div>
                    <hr>
                    <p><strong><i class="fas fa-phone me-2"></i>Phone:</strong><br>{{ $patient->phone }}</p>
                    <p><strong><i class="fas fa-calendar-alt me-2"></i>Date of
                            Birth:</strong><br>{{ $patient->date_of_birth }}
                        ({{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years old)</p>
                    <p><strong><i class="fas fa-map-marker-alt me-2"></i>Address:</strong><br>{{ $patient->address }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Medical History -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <span>Medical History</span>
                </div>
                <div class="card-body">
                    @forelse($patient->medicalRecords as $record)
                        <div class="mb-4 p-3 bg-light rounded border-start border-4 border-primary shadow-sm">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold">Visited: {{ $record->visit_date->format('M d, Y') }}</span>
                                <span class="text-muted">Dr. {{ $record->doctor->user->name }}</span>
                            </div>
                            <div class="mb-2"><strong>Diagnosis:</strong> {{ $record->diagnosis }}</div>
                            <div class="mb-0"><strong>Treatment:</strong> {{ $record->treatment }}</div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">No medical records available.</div>
                    @endforelse
                </div>
            </div>

            <!-- Appointment History -->
            <div class="card">
                <div class="card-header">Appointment History</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Doctor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient->appointments as $appt)
                                <tr>
                                    <td>{{ $appt->appointment_date->format('M d, Y h:i A') }}</td>
                                    <td>Dr. {{ $appt->doctor->user->name }}</td>
                                    <td><span
                                            class="badge bg-{{ $appt->status === 'Completed' ? 'success' : ($appt->status === 'Cancelled' ? 'danger' : 'primary') }}">{{ $appt->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No appointments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection