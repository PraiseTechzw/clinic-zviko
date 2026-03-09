@extends('layouts.app')

@section('title', 'Appointment Registry')

@section('content')
    <div class="row align-items-center mb-5 animate__animated animate__fadeInDown">
        <div class="col-md-7">
            <h1 class="fw-bold mb-1" style="letter-spacing: -1px;">Clinical Schedule</h1>
            <p class="text-muted fs-5 mb-0">Monitor and manage all patient bookings, status transitions, and clinical
                timing.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <a href="{{ url('/appointments/create') }}" class="btn btn-primary px-4 py-3 shadow">
                <i class="fas fa-calendar-plus me-2"></i>Schedule Consultation
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
        <div class="card-header bg-white border-bottom py-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-alt text-primary me-2"></i>Global Schedule</h5>
            <span class="badge bg-light text-primary border border-primary border-opacity-10 px-3 py-2 rounded-pill">Showing
                All Entries</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                            <th class="ps-4 py-4">Timing & Date</th>
                            <th class="py-4">Patient Profile</th>
                            <th class="py-4">Assigned Specialist</th>
                            <th class="py-4">Operational Status</th>
                            <th class="py-4 text-end pe-4">Management</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($appointments as $appt)
                            <tr class="animate__animated animate__fadeIn" style="animation-duration: 0.3s;">
                                <td class="ps-4">
                                    <div class="d-flex flex-column">
                                        <span
                                            class="fw-bold text-dark fs-6">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}</span>
                                        <small class="text-muted fw-medium"><i
                                                class="far fa-clock me-1 opacity-50"></i>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('/patients/' . $appt->patient_id) }}"
                                        class="text-decoration-none d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2"
                                            style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user small"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $appt->patient->full_name }}</span>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light text-secondary rounded-circle p-1 me-2"
                                            style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user-md small"></i>
                                        </div>
                                        <span class="text-muted fw-medium">Dr. {{ $appt->doctor->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ url('/appointments/' . $appt->id . '/status') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="form-select form-select-sm rounded-pill px-3 py-1 bg-light border-0 w-auto fw-bold"
                                            style="font-size: 0.8rem; cursor: pointer;">
                                            @php
                                                $statuses = ['Scheduled', 'Rescheduled', 'Cancelled', 'Completed'];
                                            @endphp
                                            @foreach($statuses as $status)
                                                <option value="{{ $status }}" {{ $appt->status === $status ? 'selected' : '' }}>
                                                    {{ $status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group gap-2">
                                        @if($appt->notes)
                                            <button class="btn btn-outline-info btn-sm rounded-circle p-2"
                                                style="width: 36px; height: 36px;" title="View Intake Notes"
                                                data-bs-toggle="popover" data-bs-trigger="focus"
                                                data-bs-content="{{ $appt->notes }}">
                                                <i class="fas fa-sticky-note"></i>
                                            </button>
                                        @endif
                                        <a href="{{ url('/appointments/' . $appt->id . '/edit') }}"
                                            class="btn btn-outline-primary btn-sm rounded-circle p-2"
                                            style="width: 36px; height: 36px;" title="Modify Schedule">
                                            <i class="fas fa-calendar-edit"></i>
                                        </a>
                                        <form action="{{ url('/appointments/' . $appt->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Archive this appointment record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle p-2"
                                                style="width: 36px; height: 36px;" title="Remove Record">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/no-appointment-booked-5321683-4444583.png"
                                        alt="No data" style="width: 200px; opacity: 0.6;">
                                    <h5 class="mt-4 text-muted fw-bold">No Active Schedules Logged</h5>
                                    <p class="text-muted px-5">Your clinic schedule is currently empty. Start by booking a new
                                        patient consultation.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($appointments->hasPages())
                <div class="px-5 py-4 border-top bg-light rounded-bottom-4">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Script to enable Popover for notes -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })
        });
    </script>
@endsection