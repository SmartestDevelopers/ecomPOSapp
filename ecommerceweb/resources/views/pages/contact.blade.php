@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <h1>Contact Us</h1>
                <p class="lead">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Send us a Message</h5>
                            <form method="POST" action="{{ route('contact.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Get in Touch</h5>
                            <div class="mb-3">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <strong>Address:</strong><br>
                                123 Commerce Street<br>
                                Business City, BC 12345
                            </div>
                            <div class="mb-3">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <strong>Phone:</strong><br>
                                +1 (555) 123-4567
                            </div>
                            <div class="mb-3">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <strong>Email:</strong><br>
                                support@ecommercestore.com
                            </div>
                            <div class="mb-3">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <strong>Business Hours:</strong><br>
                                Monday - Friday: 9:00 AM - 6:00 PM<br>
                                Saturday: 10:00 AM - 4:00 PM<br>
                                Sunday: Closed
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body text-center">
                            <h5 class="card-title">Follow Us</h5>
                            <div class="d-flex justify-content-center">
                                <a href="#" class="btn btn-outline-primary me-2">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary me-2">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
