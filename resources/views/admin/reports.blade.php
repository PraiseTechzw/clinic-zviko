@extends('layouts.app')

@section('title', 'System Reports')

@section('content')
    <h2 class="fw-bold mb-4">System Reports & Analytics</h2>

    <div class="row">
        <!-- Patient Visits Report -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Patient Visit Distribution</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <p class="text-muted small">Summary of patient visits by gender.</p>
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 60%;" aria-valuenow="60"
                                aria-valuemin="0" aria-valuemax="100">Male (60%)</div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 35%;" aria-valuenow="35"
                                aria-valuemin="0" aria-valuemax="100">Female (35%)</div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 5%;" aria-valuenow="5"
                                aria-valuemin="0" aria-valuemax="100">Other (5%)</div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Registered Patients
                            <span class="badge bg-primary rounded-pill">{{ $total_patients }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            New Patients This Month
                            <span class="badge bg-success rounded-pill">12</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Appointment Statistics -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Appointment Status Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Scheduled</td>
                                    <td class="fw-bold">{{ $appointment_stats['Scheduled'] ?? 0 }}</td>
                                    <td class="text-success"><i class="fas fa-arrow-up"></i> 5%</td>
                                </tr>
                                <tr>
                                    <td>Completed</td>
                                    <td class="fw-bold">{{ $appointment_stats['Completed'] ?? 0 }}</td>
                                    <td class="text-success"><i class="fas fa-arrow-up"></i> 12%</td>
                                </tr>
                                <tr>
                                    <td>Cancelled</td>
                                    <td class="fw-bold">{{ $appointment_stats['Cancelled'] ?? 0 }}</td>
                                    <td class="text-danger"><i class="fas fa-arrow-down"></i> 2%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-outline-primary btn-sm mt-2 w-100">Export as PDF</button>
                </div>
            </div>
        </div>

        <!-- Staff Activity -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Doctor Activity Log (Consultations)</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Specialization</th>
                                <th>Consultations Completed</th>
                                <th>Efficiency Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctor_activity as $doctor)
                                <tr>
                                    <td>Dr. {{ $doctor->user->name }}</td>
                                    <td>{{ $doctor->specialization }}</td>
                                    <td>{{ $doctor->medical_records_count }}</td>
                                    <td>
                                        <div class="progress" style="height: 10px; width: 100px;">
                                            <div class="progress-bar bg-success" style="width: 85%;"></div>
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
@endsection