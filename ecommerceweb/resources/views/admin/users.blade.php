@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>User Management</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-header">
                    <h5>All Users ({{ $users->total() }})</h5>
                </div>
                <div class="card-body">
                    @if($users->isEmpty())
                        <p class="text-muted">No users found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Verified</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($user->role === 'admin') bg-danger
                                                @else bg-primary
                                                @endif">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->email_verified_at)
                                                <span class="badge bg-success">Verified</span>
                                            @else
                                                <span class="badge bg-warning">Unverified</span>
                                            @endif
                                        </td>
                                        <td>{{ date('M d, Y', strtotime($user->created_at)) }}</td>
                                        <td>
                                            @if($user->id != auth()->id())
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                                        Change Role
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if($user->role !== 'admin')
                                                            <li>
                                                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="role" value="admin">
                                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Make this user an admin?')">
                                                                        Make Admin
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        @if($user->role !== 'customer')
                                                            <li>
                                                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="role" value="customer">
                                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Make this user a customer?')">
                                                                        Make Customer
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            @else
                                                <span class="text-muted">Current User</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
