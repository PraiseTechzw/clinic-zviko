@extends('layouts.app')

@section('title', 'Manage Staff')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Staff Directory</h2>
        <a href="#" class="btn btn-primary d-none"><i class="fas fa-plus me-2"></i>Add Staff Member</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Specialization (if Doctor)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->user->name }}</td>
                            <td>{{ $doctor->user->email }}</td>
                            <td><span class="badge bg-info">Doctor</span></td>
                            <td>{{ $doctor->specialization }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection