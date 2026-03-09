@extends('layouts.app')

@section('title', (auth()->user()->role === 'admin' ? 'Admin' : 'Receptionist') . ' Dashboard')

@section('content')
    <div class="row mb-5">
        <div class="col-lg-8">
            <h2 class="fw-bold mb-1 text-primary">
                {{ auth()->user()->role === 'admin' ? 'Administration Authority' : 'Front Desk Operations' }}
            </h2>
            <p class="text-muted">Welcome back, <strong>{{ auth()->user()->name }}</strong>. Here's your clinic pulse for
                today.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="d-inline-flex align-items-center bg-white border rounded-pill px-4 py-2 shadow-sm">
                <i class="fas fa-calendar-day text-primary me-3"></i>
                <span class="fw-bold text-dark">{{ now()->format('l, F jS Y') }}</span>
            </div>
        </div>
    </div>

    @if($urgent_alerts->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 bg-danger bg-opacity-10 rounded-4 p-2 shadow-sm animate-pulse-subtle">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-danger rounded-circle text-white me-4 shadow-sm">
                                <i class="fas fa-bell fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-danger">Immediate Schedule Alert</h6>
                                <p class="mb-0 text-dark small">You have <strong>{{ $urgent_alerts->count() }}</strong> appointment(s) commencing within the next 60 minutes. Please confirm clinic readiness.</p>
                            </div>
                        </div>
                        <button class="btn btn-danger btn-sm rounded-pill px-4" type="button" data-bs-toggle="collapse" data-bs-target="#alertDetails">
                            View Alerts
                        </button>
                    </div>
                </div>
                <div class="collapse mt-2" id="alertDetails">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <div class="row g-3">
                            @foreach($urgent_alerts as $alert)
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-4 border">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="badge bg-danger">Next Patient</span>
                                            <span class="badge bg-white text-dark border">{{ $alert->appointment_date->diffForHumans() }}</span>
                                        </div>
                                        <h6 class="fw-bold mb-1">{{ $alert->patient->full_name }}</h6>
                                        <small class="text-muted"><i class="fas fa-user-md me-2"></i>Assigned to Dr. {{ $alert->doctor->user->name }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                            style="width: 48px; height: 48px;">
                            <i class="fas fa-user-injured fs-5"></i>
                        </div>
                        <h6 class="text-secondary fw-bold mb-0">Total Patients</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h2 class="fw-bold mb-0 text-dark">{{ number_format($stats['total_patients']) }}</h2>
                        <span
                            class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 small">+{{ $stats['total_patients'] }}
                            all time</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center me-3"
                            style="width: 48px; height: 48px;">
                            <i class="fas fa-calendar-check fs-5"></i>
                        </div>
                        <h6 class="text-secondary fw-bold mb-0">Daily Bookings</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h2 class="fw-bold mb-0 text-dark">{{ number_format($stats['appointments_today']) }}</h2>
                        <span class="text-muted small">Today's load</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center me-3"
                            style="width: 48px; height: 48px;">
                            <i class="fas fa-user-md fs-5"></i>
                        </div>
                        <h6 class="text-secondary fw-bold mb-0">Medical Staff</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h2 class="fw-bold mb-0 text-dark">{{ number_format($stats['active_doctors']) }}</h2>
                        <span class="text-muted small">Active Personnel</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center me-3"
                            style="width: 48px; height: 48px;">
                            <i class="fas fa-clipboard-list fs-5"></i>
                        </div>
                        <h6 class="text-secondary fw-bold mb-0">Total Records</h6>
                    </div>
                    <div class="d-flex align-items-end justify-content-between">
                        <h2 class="fw-bold mb-0 text-dark">{{ number_format($stats['total_records']) }}</h2>
                        <span class="text-muted small">Clinical Data</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <!-- Recent Activity -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white border-0 py-4 ps-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-history me-3 text-primary"></i>Recent Appointment Feed</h5>
                    <a href="/appointments" class="btn btn-outline-primary btn-sm rounded-pill px-4">See Schedule</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Patient Name</th>
                                    <th>Assigned Doctor</th>
                                    <th>Time Frame</th>
                                    <th class="text-end pe-4">Current Case Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_appointments as $appt)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 bg-light rounded-circle me-3">
                                                    <i class="fas fa-user-injured text-secondary small"></i>
                                                </div>
                                                <span class="fw-bold text-dark">{{ $appt->patient->full_name }}</span>
                                            </div>
                                        </td>
                                        <td>Dr. {{ $appt->doctor->user->name }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $appt->appointment_date->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $appt->appointment_date->format('h:i A') }}</small>
                                        </td>
                                        <td class="text-end pe-4">
                                            <span
                                                class="badge rounded-pill bg-{{ $appt->status === 'Scheduled' ? 'primary' : ($appt->status === 'Completed' ? 'success' : 'danger') }} bg-opacity-10 text-{{ $appt->status === 'Scheduled' ? 'primary' : ($appt->status === 'Completed' ? 'success' : 'danger') }} px-3 border-0">
                                                {{ $appt->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="opacity-25 mb-2"><i class="fas fa-calendar-times display-4"></i></div>
                                            No recent appointments found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doctor Resource View -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-0 py-4 ps-4">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-stethoscope me-3 text-primary"></i>Clinical Load Pool</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($doctors as $doctor)
                            <div class="list-group-item border-0 py-4 px-4 hover-bg-light transition-all">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">Dr. {{ $doctor->user->name }}</h6>
                                        <small
                                            class="text-secondary text-uppercase fw-bold ls-1 small-xs">{{ $doctor->specialization }}</small>
                                    </div>
                                    <span class="badge rounded-pill bg-dark py-2 px-3">{{ $doctor->appointments_count }}
                                        Queued</span>
                                </div>
                                <div class="progress mt-3" style="height: 6px;">
                                    @php 
                                                                            $max_appt = $doctors->max('appointments_count') ?: 1;
                                        $perc = ($doctor->appointments_count / $max_appt) * 100;
                                    @endphp
                                        <div class="progress-bar bg-primary rounded-pill shadow-none" style="width: {{ $perc }}%;"></div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
@endsection
       
   



       
   
<style>

       
   
    .ls-1 { letter-sp
       acing: 1px; }

       .small-xs { font-size: 0.75rem; }
    .hover-bg-light:hover { background-color: #f8f9fa; }
    .transition-all { transition: all 0.3s ease; }
    
    .animate-pulse-subtle {
        animation: pulse-subtle 2s infinite;
    }
    
    @keyframes pulse-subtle {
        0% { transform: scale(1); }
        50% { transform: scale(1.005); }
        100% { transform: scale(1); }
    }
</style>