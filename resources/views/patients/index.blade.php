@extends('layouts.app')

@section('title', 'Patient Directory')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-primary">Patient Directory</h2>
            <p class="text-muted small">Search and manage all registered clinic patients.</p>
        </div>
        <a href="{{ url('/patients/create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-user-plus me-2"></i>Register New Patient
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 ps-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 ps-4">
            <form action="{{ url('/patients') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-8 col-lg-6">
                    <div class="input-group rounded-pill bg-light overflow-hidden px-2 border">
                        <span class="input-group-text bg-transparent border-0"><i
                                class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none py-2"
                            placeholder="Search by name or phone..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-dark rounded-pill px-4">Search</button>
                    @if(request('search'))
                        <a href="{{ url('/patients') }}" class="btn btn-link link-secondary text-decoration-none small">Clear
                            Filters</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3">Patient Profile</th>
                            <th class="py-3">Demographics</th>
                            <th class="py-3">Primary Contact</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center py-2">
                                        <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                                            style="width: 42px; height: 42px;">
                                            {{ strtoupper(substr($patient->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $patient->full_name }}</h6>
                                            <small class="text-muted">Registered:
                                                {{ $patient->created_at->format('M Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-light text-dark border px-3 mb-1">
                                        {{ $patient->gender }}
                                    </span>
                                    <div class="small text-muted ps-1">
                                        {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years old
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold fs-7">{{ $patient->phone }}</div>
                                    <small class="text-muted">{{ Str::limit($patient->address, 30) }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group gap-2 shadow-none">
                                        <a href="{{ url('/patients/' . $patient->id) }}"
                                            class="btn btn-sm btn-light border-0 rounded-circle py-2 px-2 shadow-sm"
                                            title="View Full Profile">
                                            <i class="fas fa-external-link-alt text-primary small"></i>
                                        </a>
                                        <a href="{{ url('/patients/' . $patient->id . '/edit') }}"
                                            class="btn btn-sm btn-light border-0 rounded-circle py-2 px-2 shadow-sm"
                                            title="Edit Data">
                                            <i class="fas fa-pen text-secondary small"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="fas fa-users-slash display-4 d-block mb-3 opacity-25"></i>
                                    <p class="text-muted mb-0">No patient records found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($patients->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $patients->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection