@extends('layouts.app')

@section('title', (auth()->user()->role === 'admin' ? 'Administrative' : 'Reception') . ' Hub')

@section('content')
    <div class="row align-items-center mb-5 animate__animated animate__fadeInDown">
        <div class="col-lg-7">
            <h1 class="fw-bold mb-1" style="letter-spacing: -1px;">
                {{ auth()->user()->role === 'admin' ? 'Center of Operations' : 'Welcome to Reception' }}
            </h1>
            <p class="text-muted fs-5 mb-0">Hello, <strong>{{ auth()->user()->name }}</strong>. Here's what's happening today at the clinic.</p>
        </div>
        <div class="col-lg-5 text-lg-end mt-3 mt-lg-0">
            <div class="d-inline-flex align-items-center bg-white shadow-sm rounded-4 px-4 py-3 border">
                <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                    <i class="fas fa-calendar-alt text-primary"></i>
                </div>
                <div class="text-start">
                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Current Date</small>
                    <span class="fw-bold h6 mb-0">{{ now()->format('l, F jS Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    @if($urgent_alerts->count() > 0)
        <div class="row mb-5 animate__animated animate__shakeX">
            <div class="col-12">
                <div class="card border-0 overflow-hidden" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-circle text-danger me-4 shadow-sm animate__animated animate__pulse animate__infinite" style="background: rgba(220, 38, 38, 0.15);">
                                <i class="fas fa-clock fa-xl"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1 text-danger">Incoming Appointments</h5>
                                <p class="mb-0 text-danger-emphasis">You have <strong>{{ $urgent_alerts->count() }}</strong> patients expected within the next hour.</p>
                            </div>
                        </div>
                        <button class="btn btn-danger px-4 rounded-pill shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#alertDetails">
                            Monitor Live Queue
                        </button>
                    </div>
                </div>
                <div class="collapse mt-3" id="alertDetails">
                    <div class="card border-0 shadow-lg p-4 rounded-4" style="background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px);">
                        <div class="row g-4">
                            @foreach($urgent_alerts as $alert)
                                <div class="col-md-6 col-xl-4 text-center text-md-start">
                                    <div class="p-4 bg-white rounded-4 border-start border-4 border-danger shadow-sm h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge border border-danger border-opacity-25 rounded-pill" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;">Immediate</span>
                                            <small class="text-muted fw-bold"><i class="fas fa-stopwatch me-1"></i> {{ $alert->appointment_date->diffForHumans() }}</small>
                                        </div>
                                        <h6 class="fw-bold h5 mb-2">{{ $alert->patient->full_name }}</h6>
                                        <div class="d-flex align-items-center text-muted small">
                                            <div class="bg-light p-1 rounded-circle me-2" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-stethoscope"></i>
                                            </div>
                                            Dr. {{ $alert->doctor->user->name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Stats Section -->
    <div class="row g-4 mb-5">
        <div class="col-sm-6 col-xl-3 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
            <div class="card border-0 h-100 p-2 overflow-hidden" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="p-3 rounded-4 shadow-sm" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px);">
                            <i class="fas fa-user-injured fa-2x text-white"></i>
                        </div>
                        <span class="badge rounded-pill fw-bold" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px);">Total Database</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ number_format($stats['total_patients']) }}</h2>
                    <p class="mb-0 opacity-75 fw-medium small text-uppercase" style="letter-spacing: 1px;">Registered Patients</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
            <div class="card border-0 h-100 p-2" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="p-3 rounded-4 shadow-sm" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px);">
                            <i class="fas fa-calendar-check fa-2x text-white"></i>
                        </div>
                        <span class="badge rounded-pill fw-bold" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px);">Daily Traffic</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ number_format($stats['appointments_today']) }}</h2>
                    <p class="mb-0 opacity-75 fw-medium small text-uppercase" style="letter-spacing: 1px;">Appointments Today</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
            <div class="card border-0 h-100 p-2" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="p-3 rounded-4 shadow-sm" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px);">
                            <i class="fas fa-user-md fa-2x text-white"></i>
                        </div>
                        <span class="badge rounded-pill fw-bold" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px);">Medical Staff</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ number_format($stats['active_doctors']) }}</h2>
                    <p class="mb-0 opacity-75 fw-medium small text-uppercase" style="letter-spacing: 1px;">Active Specialists</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
            <div class="card border-0 h-100 p-2" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="p-3 rounded-4 shadow-sm" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px);">
                            <i class="fas fa-notes-medical fa-2x text-white"></i>
                        </div>
                        <span class="badge rounded-pill fw-bold" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px);">Health Data</span>
                    </div>
                    <h2 class="display-5 fw-bold mb-1">{{ number_format($stats['total_records']) }}</h2>
                    <p class="mb-0 opacity-75 fw-medium small text-uppercase" style="letter-spacing: 1px;">Total Medical Records</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables and Activity -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm animate__animated animate__fadeInLeft">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-stream text-primary me-2"></i>Recent Patient Flow
                    </div>
                    <a href="/appointments" class="btn btn-sm btn-light text-primary fw-bold">View Full Registry</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    <th class="ps-4 py-3">Patient Profile</th>
                                    <th class="py-3">Physician</th>
                                    <th class="py-3">Schedule</th>
                                    <th class="text-end pe-4 py-3">Live Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_appointments as $appt)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center py-2">
                                                <div class="rounded-pill p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: rgba(99, 102, 241, 0.1); color: var(--primary);">
                                                    <i class="fas fa-user-injured small"></i>
                                                </div>
                                                <span class="fw-bold fs-6">{{ $appt->patient->full_name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="p-1 bg-light rounded-circle me-2">
                                                    <i class="fas fa-user-md text-secondary" style="font-size: 0.8rem;"></i>
                                                </div>
                                                Dr. {{ $appt->doctor->user->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $appt->appointment_date->format('M d, Y') }}</div>
                                            <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $appt->appointment_date->format('h:i A') }}</small>
                                        </td>
                                        <td class="text-end pe-4">
                                            @php
                                                $status_color = [
                                                    'Scheduled' => 'primary',
                                                    'Completed' => 'success',
                                                    'Cancelled' => 'danger',
                                                    'Rescheduled' => 'warning'
                                                ][$appt->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge border border-{{ $status_color }} border-opacity-25 px-3" style="background: rgba({{ $status_color === 'primary' ? '99, 102, 241' : ($status_color === 'success' ? '16, 185, 129' : ($status_color === 'danger' ? '239, 68, 68' : '245, 158, 11')) }}, 0.1); color: var(--{{ $status_color }});">
                                                {{ $appt->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <img src="https://cdni.iconscout.com/illustration/premium/thumb/no-data-found-8867280-7223910.png" alt="No data" style="width: 150px; opacity: 0.5;">
                                            <p class="mt-3">No recent appointments recorded.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 animate__animated animate__fadeInRight">
                <div class="card-header pb-3">
                    <i class="fas fa-stethoscope text-primary me-2"></i>Specialist Load Monitor
                </div>
                <div class="card-body p-4">
                    @foreach($doctors as $doctor)
                        @php 
                            $max_appt = $doctors->max('appointments_count') ?: 1;
                            $perc = ($doctor->appointments_count / $max_appt) * 100;
                        @endphp
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <div>
                                    <h6 class="fw-bold mb-0">Dr. {{ $doctor->user->name }}</h6>
                                    <small class="text-muted text-uppercase fw-medium" style="font-size: 0.65rem;">{{ $doctor->specialization }}</small>
                                </div>
                                <span class="badge bg-dark rounded-pill">{{ $doctor->appointments_count }} Active</span>
                            </div>
                            <div class="progress rounded-pill shadow-none" style="height: 10px; background: #f1f5f9;">
                                <div class="progress-bar rounded-pill bg-primary" role="progressbar" 
                                     style="width: {{ $perc }}%;" 
                                     aria-valuenow="{{ $perc }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="alert border-0 rounded-4 p-3 mt-4 mb-0" style="background: rgba(99, 102, 241, 0.1); color: var(--primary);">
                        <small class="fw-bold"><i class="fas fa-info-circle me-1"></i> Data automatically refreshes every 5 minutes to ensure clinical load balancing.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
