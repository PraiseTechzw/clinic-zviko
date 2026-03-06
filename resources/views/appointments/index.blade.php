@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Appointment Calendar</h2>
        <a href="/appointments/create" class="btn btn-primary"><i class="fas fa-calendar-plus me-2"></i>Book Appointment</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                        <tr>
                            <td>{{ $appt->appointment_date->format('M d, Y h:i A') }}</td>
                            <td>{{ $appt->patient->full_name }}</td>
                            <td>Dr. {{ $appt->doctor->user->name }}</td>
                            <td>
                                <form action="/appointments/{{ $appt->id }}/status" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                        class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="Scheduled" {{ $appt->status === 'Scheduled' ? 'selected' : '' }}>Scheduled
                                        </option>
                                        <option value="Rescheduled" {{ $appt->status === 'Rescheduled' ? 'selected' : '' }}>
                                            Rescheduled</option>
                                        <option value="Cancelled" {{ $appt->status === 'Cancelled' ? 'selected' : '' }}>Cancelled
                                        </option>
                                        <option value="Completed" {{ $appt->status === 'Completed' ? 'selected' : '' }}>Completed
                                        </option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary" title="View Notes"
                                    onclick="alert('{{ $appt->notes }}')">Notes</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No appointments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $appointments->links() }}
        </div>
    </div>
@endsection