@extends('layouts.app')

@section('title', 'System Reports')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold mb-0">System Reports & Analytics</h2>
            <p class="text-muted">A comprehensive look at clinic performance and patient data.</p>
        </div>
        <div class="col-auto">
            <button onclick="window.print()" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-print me-2"></i>Print Report
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Patient Visits Report -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-4 ps-4">
                    <h5 class="mb-0 fw-bold">Patient Demographics</h5>
                </div>
                <div class="card-body px-4">
                    <div class="mb-5">
                        <p class="text-muted small mb-3">Gender distribution within registered patients.</p>
                        @php
                            $total = $total_patients ?: 1;
                            $m_perc = (($gender_dist['Male'] ?? 0) / $total) * 100;
                            $f_perc = (($gender_dist['Female'] ?? 0) / $total) * 100;
                            $o_perc = (($gender_dist['Other'] ?? 0) / $total) * 100;
                        @endphp
                        <div class="progress rounded-pill overflow-hidden shadow-sm" style="height: 30px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $m_perc }}%;" 
                                title="Male: {{ $gender_dist['Male'] ?? 0 }}">
                                {{ round($m_perc) }}%
                            </div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $f_perc }}%;"
                                title="Female: {{ $gender_dist['Female'] ?? 0 }}">
                                {{ round($f_perc) }}%
                            </div>
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $o_perc }}%;"
                                title="Other: {{ $gender_dist['Other'] ?? 0 }}">
                                {{ round($o_perc) }}%
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3 gap-4 small fw-bold">
                            <span><i class="fas fa-circle text-primary me-1"></i> Male</span>
                            <span><i class="fas fa-circle text-danger me-1"></i> Female</span>
                            <span><i class="fas fa-circle text-info me-1"></i> Other</span>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-4 text-center">
                                <h3 class="fw-bold text-primary mb-1">{{ $total_patients }}</h3>
                                <small class="text-muted text-uppercase fw-bold ls-1">Total Patients</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-4 text-center">
                                <h3 class="fw-bold text-success mb-1">{{ array_sum($appointment_stats) }}</h3>
                                <small class="text-muted text-uppercase fw-bold ls-1">Total Bookings</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Statistics -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-4 ps-4">
                    <h5 class="mb-0 fw-bold">Appointment Status Summary</h5>
                </div>
                <div class="card-body px-4">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead class="bg-light text-secondary rounded-3">
                                <tr>
                                    <th class="ps-3 border-0 rounded-start">Status</th>
                                    <th class="text-center border-0">Total Count</th>
                                    <th class="text-end pe-3 border-0 rounded-end">Distribution</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $all_appts = array_sum($appointment_stats) ?: 1;
                                    $statuses = ['Scheduled', 'Completed', 'Cancelled', 'Rescheduled'];
                                    $colors = ['primary', 'success', 'danger', 'warning'];
                                @endphp
                                @foreach($statuses as $index => $status)
                                    @php 
                                        $count = $appointment_stats[$status] ?? 0; 
                                        $p = ($count / $all_appts) * 100;
                                    @endphp
                                    <tr>
                                        <td class="ps-3"><span class="badge rounded-pill bg-{{ $colors[$index] }} bg-opacity-10 text-{{ $colors[$index] }} px-3">{{ $status }}</span></td>
                                        <td class="text-center fw-bold">{{ $count }}</td>
                                        <td class="text-end pe-3" style="width: 120px;">
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-{{ $colors[$index] }}" style="width: {{ $p }}%;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Activity -->
        <div class="col-12 mt-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-4 ps-4">
                    <h5 class="mb-0 fw-bold">Doctor Consultations Log</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4">Doctor Name</th>
                                    <th>Specialization</th>
                                    <th class="text-center">Total Records Saved</th>
                                    <th class="text-end pe-4">Activity Indicator</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doctor_activity as $doctor)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-stethoscope text-primary small"></i>
                                                </div>
                                                <span class="fw-bold">Dr. {{ $doctor->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $doctor->specialization }}</td>
                                        <td class="text-center fw-bold text-dark">{{ $doctor->medical_records_count }}</td>
                                        <td class="text-end pe-4">
                                            @php 
                                                $max_records = $doctor_activity->max('medical_records_count') ?: 1;
                                                $activity_perc = ($doctor->medical_records_count / $max_records) * 100;
                                            @endphp
                                            <div class="progress ms-auto" style="height: 8px; width: 150px;">
                                                <div class="progress-bar bg-success rounded-pill" style="width: {{ $activity_perc }}%;"></div>
                                            </div>
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
    .ls-1 { letter-spacing: 1px; }
</style>