@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Appointments Management</h2>
            <p class="text-muted small">Overview of all clinic schedules and status updates.</p>
        </div>
        <a href="{{ url('/appointments/create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-calendar-plus me-2"></i>Book New Appointment
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3">Scheduled Time</th>
                            <th class="py-3">Patient</th>
                            <th class="py-3">Doctor</th>
                            <th class="py-3">Current Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appt)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}
                                    </div>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <a href="{{ url('/patients/' . $appt->patient_id) }}"
                                        class="text-decoration-none fw-bold text-dark">
                                        {{ $appt->patient->first_name }} {{ $appt->patient->last_name }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs rounded-circle bg-light text-primary d-flex align-items-center justify-content-center me-2"
                                            style="width: 24px; height: 24px;">
                                            <i class="fas fa-user-md small"></i>
                                        </div>
                                        <span>Dr. {{ $appt->doctor->user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ url('/appointments/' . $appt->id . '/status') }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="form-select form-select-sm rounded-pill px-3 py-1 bg-light border-0 w-auto">
                                            <option value="Scheduled" {{ $appt->status === 'Scheduled' ? 'selected' : '' }}>
                                                Scheduled</option>
                                            <option value="Rescheduled" {{ $appt->status === 'Rescheduled' ? 'selected' : '' }}>
                                                Rescheduled</option>
                                            <option value="Cancelled" {{ $appt->status === 'Cancelled' ? 'selected' : '' }}>
                                                Cancelled</option>
                                            <option value="Completed" {{ $appt->status === 'Completed' ? 'selected' : '' }}>
                                                Completed</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-none gap-2">
                                        @if($appt->notes)
                                            <button class="btn btn-sm btn-light rounded-circle shadow-none border"
                                                title="View Notes" data-bs-toggle="popover" data-bs-content="{{ $appt->notes }}">
                                                <i class="fas fa-info-circle text-info"></i>
                                            </button>
                                        @endif
                                        <a href="{{ url('/appointments/' . $appt->id . '/edit') }}"
                                            class="btn btn-sm btn-light rounded-circle shadow-none border"
                                            title="Edit Schedule">
                                            <i class="fas fa-clock text-primary"></i>
                                        </a>
                                        <form action="{{ url('/appointments/' . $appt->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Archive this appointment record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light rounded-circle shadow-none border"
                                                title="Delete record">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-calendar-times display-4 d-block mb-3 opacity-25"></i>
                                    No appointments scheduled.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-top">
                {{ $appointments->links() }}
            </div>
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