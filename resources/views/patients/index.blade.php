@extends('layouts.app')

@section('title', 'Patients')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Patient Management</h2>
        <a href="/patients/create" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Register New Patient</a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="/patients" method="GET" class="row g-2">
                <div class="col-auto">
                    <input type="text" name="search" class="form-control" placeholder="Search patients..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-secondary">Search</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Phone</th>
                        <th>Last Visit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->full_name }}</td>
                            <td>{{ $patient->gender }}</td>
                            <td>{{ $patient->date_of_birth }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->updated_at->format('M d, Y') }}</td>
                            <td>
                                <a href="/patients/{{ $patient->id }}" class="btn btn-sm btn-outline-info">View</a>
                                <a href="/patients/{{ $patient->id }}/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No patients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $patients->links() }}
        </div>
    </div>
@endsection