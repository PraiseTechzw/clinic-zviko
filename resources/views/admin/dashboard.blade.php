@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">Administrator Dashboard</h2>
            <p class="text-muted">System Overview and Statistics</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-circle me-3">
                        <i class="fas fa-user-injured text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Total Patients</h6>
                        <h3 class="mb-0">{{ $stats['total_patients'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3" style="border-left-color: #2ecc71;">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-success bg-opacity-10 rounded-circle me-3">
                        <i class="fas fa-calendar-check text-success"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Appointments Today</h6>
                        <h3 class="mb-0">{{ $stats['appointments_today'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3" style="border-left-color: #e67e22;">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-warning bg-opacity-10 rounded-circle me-3">
                        <i class="fas fa-user-md text-warning"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Active Doctors</h6>
                        <h3 class="mb-0">{{ $stats['active_doctors'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3" style="border-left-color: #9b59b6;">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-info bg-opacity-10 rounded-circle me-3">
                        <i class="fas fa-clipboard-list text-info"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Total Records</h6>
                        <h3 class="mb-0">{{ $stats['total_records'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Appointments</span>
                    <a href="/appointments" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_appointments as $appt)
                                <tr>
                                    <td>{{ $appt->patient->full_name }}</td>
                                    <td>Dr. {{ $appt->doctor->user->name }}</td>
                                    <td>{{ $appt->appointment_date->format('M d, Y h:i A') }}</td>
                                    <td><span
                                            class="badge bg-{{ $appt->status === 'Completed' ? 'success' : ($appt->status === 'Cancelled' ? 'danger' : 'primary') }}">{{ $appt->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No appointments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Doctor Schedules</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($doctors as $doctor)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <span class="fw-bold">Dr. {{ $doctor->user->name }}</span><br>
                                    <small class="text-muted">{{ $doctor->specialization }}</small>
                                </div>
                                <span class="badge bg-secondary rounded-pill">{{ $doctor->appointments_count }} appts</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection