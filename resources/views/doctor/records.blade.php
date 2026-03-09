@extends('layouts.app')

@section('title', 'Medical Records Archive')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-primary">Patient History Vault</h2>
            <p class="text-muted small">Search and review comprehensive medical histories of all patients.</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 ps-4">
            <form action="{{ url('/doctor/records') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-9 col-lg-7">
                    <div class="input-group rounded-pill bg-light overflow-hidden px-2 border">
                        <span class="input-group-text bg-transparent border-0"><i
                                class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control bg-transparent border-0 shadow-none py-2"
                            placeholder="Search by Patient, Diagnosis, or Treatment keyword..."
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Search Vault</button>
                    @if(request('search'))
                        <a href="{{ url('/doctor/records') }}"
                            class="btn btn-link link-secondary text-decoration-none small">Clear Filters</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Records Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3">Patient Account</th>
                            <th class="py-3">Visit Timeline</th>
                            <th class="py-3">Clinical Diagnosis</th>
                            <th class="py-3">Treatment Plan</th>
                            <th class="py-3 text-end pe-4">Clinical Officer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                            <tr>
                                <td class="ps-4">
                                    <h6 class="mb-0 fw-bold">{{ $record->patient->full_name }}</h6>
                                    <small class="text-muted">ID:
                                        #{{ str_pad($record->patient->id, 5, '0', STR_PAD_LEFT) }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $record->visit_date->format('M d, Y') }}</div>
                                    <small class="text-muted small-xs">{{ $record->visit_date->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <span class="text-primary fw-bold">{{ $record->diagnosis }}</span>
                                </td>
                                <td>
                                    <div class="text-muted small-xs text-truncate" style="max-width: 250px;"
                                        title="{{ $record->treatment }}">
                                        {{ $record->treatment }}
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="small fw-bold">Dr. {{ $record->doctor->user->name }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="opacity-25 mb-3">
                                        <i class="fas fa-folder-open display-1"></i>
                                    </div>
                                    <h5 class="text-muted fw-bold">No Historical Records Found</h5>
                                    <p class="text-muted small">Try refining your search keyword or clearing the filters.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($records->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

<style>
    .small-xs {
        font-size: 0.8rem;
    }

    .ls-1 {
        letter-spacing: 0.5px;
    }
</style>