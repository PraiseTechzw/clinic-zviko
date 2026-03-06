@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
    <h2 class="fw-bold mb-4">My Appointments Today</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Patient Name</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                        <tr>
                            <td>{{ $appt->appointment_date->format('h:i A') }}</td>
                            <td>
                                <span class="fw-bold">{{ $appt->patient->full_name }}</span><br>
                                <small class="text-muted">{{ $appt->patient->gender }},
                                    {{ \Carbon\Carbon::parse($appt->patient->date_of_birth)->age }} years</small>
                            </td>
                            <td><span class="badge bg-primary">{{ $appt->status }}</span></td>
                            <td class="text-muted small">{{ Str::limit($appt->notes, 50) }}</td>
                            <td>
                                <a href="/doctor/consultation/{{ $appt->patient->id }}" class="btn btn-sm btn-success">Start
                                    Consultation</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-calendar-check fa-3x mb-3"></i><br>
                                No appointments scheduled for you today.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection