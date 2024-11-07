@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Welcome to Laravel Auth</h1>
            <p class="lead mb-4">A secure and modern authentication system built with Laravel</p>
            
            <div class="row justify-content-center mb-5">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="bi bi-shield-lock fs-1 text-primary mb-3"></i>
                            <h3 class="h5">User Management</h3>
                            <p class="text-muted">Complete user authentication system</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="bi bi-person-check fs-1 text-primary mb-3"></i>
                            <h3 class="h5">Role-based Access</h3>
                            <p class="text-muted">Secure role-based authorization</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="bi bi-layout-text-window fs-1 text-primary mb-3"></i>
                            <h3 class="h5">Modern UI</h3>
                            <p class="text-muted">Clean and responsive interface</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-center">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-md-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">Register</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">Go to Dashboard</a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row my-5">
        <div class="col-12 text-center mb-4">
            <h2>Key Features</h2>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-shield-check fs-1 text-success mb-3"></i>
                    <h5 class="card-title">Secure Authentication</h5>
                    <p class="card-text">Built-in security features including password hashing and session management.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">User Roles</h5>
                    <p class="card-text">Define and manage user roles with specific permissions and access levels.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-key fs-1 text-warning mb-3"></i>
                    <h5 class="card-title">Password Recovery</h5>
                    <p class="card-text">Simple and secure password reset functionality for users.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection