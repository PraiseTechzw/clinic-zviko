@extends('layouts.app')

@section('title', 'Manage Staff')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Staff Management</h2>
            <p class="text-muted">Manage administrators, doctors, and receptionist accounts.</p>
        </div>
        <a href="{{ url('/admin/staff/create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Add Staff Member
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3">Staff Member</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Specialization</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span
                                            class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3">Administrator</span>
                                    @elseif($user->role === 'doctor')
                                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3">Doctor</span>
                                    @else
                                        <span class="badge rounded-pill bg-info bg-opacity-10 text-info px-3">Receptionist</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ $user->doctor->specialization ?? '--' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-none">
                                        <a href="{{ url('/admin/staff/' . $user->id . '/edit') }}"
                                            class="btn btn-sm btn-light border" title="Edit">
                                            <i class="fas fa-edit text-primary"></i>
                                        </a>
                                        <form action="{{ url('/admin/staff/' . $user->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to remove this staff member?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border" title="Delete" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection