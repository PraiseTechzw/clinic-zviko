@extends('layouts.app')

@section('title', 'Patient Registry')

@section('content')
    <div class="row align-items-center mb-5 animate__animated animate__fadeInDown">
        <div class="col-md-7">
            <h1 class="fw-bold mb-1" style="letter-spacing: -1px;">Patient Database</h1>
            <p class="text-muted fs-5 mb-0">Search and manage all clinic patient records in one centralized directory.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <a href="{{ url('/patients/create') }}" class="btn btn-primary px-4 py-3 shadow">
                <i class="fas fa-plus-circle me-2"></i>Register New Entry
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-5 animate__animated animate__fadeIn">
        <div class="card-body p-4">
            <form action="{{ url('/patients') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-8">
                        <div class="input-group input-group-lg border rounded-4 overflow-hidden bg-light shadow-none">
                            <span class="input-group-text bg-transparent border-0 px-4">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none py-3"
                                placeholder="Locate by Name, Identity Number or Contact Details..."
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary h-100 flex-grow-1 px-4 rounded-4">Apply
                            Filters</button>
                        @if(request('search'))
                            <a href="{{ url('/patients') }}"
                                class="btn btn-outline-secondary h-100 px-4 d-flex align-items-center justify-content-center rounded-4">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                            <th class="ps-4 py-4">Patient Profile</th>
                            <th class="py-4">Vitals & Demographics</th>
                            <th class="py-4">Contact Information</th>
                            <th class="py-4 text-end pe-4">Registry Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($patients as $patient)
                            <tr class="animate__animated animate__fadeIn" style="animation-duration: 0.3s;">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center py-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-pill p-3 me-3 fw-bold"
                                            style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                                            {{ strtoupper(substr($patient->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold fs-6">{{ $patient->full_name }}</h6>
                                            <small class="text-muted"><i class="far fa-clock me-1"></i>Since
                                                {{ $patient->created_at->format('M Y') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span
                                            class="badge bg-light text-dark border border-dark border-opacity-10 rounded-pill px-3 py-2 mb-1 w-fit-content">
                                            <i class="fas fa-venus-mars me-1 opacity-50"></i> {{ $patient->gender }}
                                        </span>
                                        <span class="small text-muted ps-1 fw-medium">
                                            <i class="fas fa-birthday-cake me-1 opacity-50"></i>
                                            {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} Years
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold mb-1 text-dark">{{ $patient->phone }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 250px;">
                                        <i class="fas fa-map-marker-alt me-1 opacity-50"></i> {{ $patient->address }}
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group gap-2">
                                        <a href="{{ url('/patients/' . $patient->id) }}"
                                            class="btn btn-outline-primary btn-sm rounded-circle p-2 shadow-sm d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px;" title="View Clinical History">
                                            <i class="fas fa-file-medical"></i>
                                        </a>
                                        <a href="{{ url('/patients/' . $patient->id . '/edit') }}"
                                            class="btn btn-outline-secondary btn-sm rounded-circle p-2 shadow-sm d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px;" title="Modify Records">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-folder-5321685-4444585.png"
                                        alt="No data" style="width: 200px; opacity: 0.6;">
                                    <h5 class="mt-4 text-muted fw-bold">No Patient Records Located</h5>
                                    <p class="text-muted px-5">The search did not yield any results from our clinical database.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($patients->hasPages())
                <div class="px-5 py-4 border-top bg-light rounded-bottom-4">
                    {{ $patients->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

<style>
    .w-fit-content {
        width: fit-content;
    }
</style>