@extends('layouts.app')

@section('title', 'Physician Workspace')

@section('content')
    <div class="row align-items-center mb-5 animate__animated animate__fadeInDown">
        <div class="col-md-7">
            <h1 class="fw-bold mb-1" style="letter-spacing: -1px;">Consultation Queue</h1>
            <p class="text-muted fs-5 mb-0">Manage your daily patient flow and review clinical history.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <div class="d-inline-flex flex-column align-items-end">
                <h4 class="fw-bold mb-0 text-primary">{{ now()->format('l, jS M Y') }}</h4>
                <div
                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 mt-2">
                    <i class="fas fa-circle-check me-2 animate__animated animate__pulse animate__infinite"></i> System
                    Online & Active
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
        <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom py-4 px-4">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list-ul text-primary me-2"></i>Upcoming Sessions</h5>
            <span class="badge bg-primary rounded-pill px-3">{{ $appointments->count() }} Pending</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                            <th class="ps-4 py-4">Time Entry</th>
                            <th class="py-4">Patient Profile</th>
                            <th class="py-4 text-center">Live Status</th>
                            <th class="py-4">Intake Summary</th>
                            <th class="py-4 text-end pe-4">Clinical Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($appointments as $appt)
                            <tr class="animate__animated animate__fadeIn" style="animation-duration: 0.4s;">
                                <td class="ps-4">
                                    <div class="d-flex flex-column">
                                        <span class="display-6 fw-bold text-dark mb-0"
                                            style="font-size: 1.5rem;">{{ $appt->appointment_date->format('H:i') }}</span>
                                        <span class="text-muted text-uppercase fw-bold ls-1"
                                            style="font-size: 0.65rem;">{{ $appt->appointment_date->format('A') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center py-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-pill p-3 me-3 fw-bold"
                                            style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                            {{ strtoupper(substr($appt->patient->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold fs-6 text-dark">{{ $appt->patient->full_name }}</h6>
                                            <small class="text-muted d-block">{{ $appt->patient->gender }},
                                                {{ \Carbon\Carbon::parse($appt->patient->date_of_birth)->age }} Years</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $status_color = $appt->status === 'Scheduled' ? 'primary' : 'warning';
                                    @endphp
                                    <span
                                        class="badge bg-{{ $status_color }} bg-opacity-10 text-{{ $status_color }} border border-{{ $status_color }} border-opacity-25 px-3 py-2">
                                        {{ $appt->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small text-muted text-truncate" style="max-width: 250px;">
                                        @if($appt->notes)
                                            <i class="fas fa-quote-left me-1 opacity-25"></i> {{ $appt->notes }}
                                        @else
                                            <span class="opacity-50 italic">No intake notes provided.</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ url('/doctor/consultation/' . $appt->patient->id) }}"
                                        class="btn btn-primary px-4 py-2 shadow-sm border-0 d-inline-flex align-items-center transition-all">
                                        <i class="fas fa-stethoscope me-2"></i>
                                        <span>Start Consult</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-schedule-9475960-7686001.png"
                                        alt="No data" style="width: 250px; opacity: 0.6;">
                                    <h5 class="mt-4 text-muted fw-bold">All Caught Up!</h5>
                                    <p class="text-muted px-5 mb-0">You have no pending appointments scheduled for the remainder
                                        of the day.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection