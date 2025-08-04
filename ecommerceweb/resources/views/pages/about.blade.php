@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-4">About ECommerce Store</h1>
                <p class="lead">Your trusted partner for quality products and exceptional service</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-heart fa-3x text-primary mb-3"></i>
                            <h4>Our Mission</h4>
                            <p>To provide high-quality products at competitive prices while delivering exceptional customer service and creating lasting relationships with our customers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-eye fa-3x text-primary mb-3"></i>
                            <h4>Our Vision</h4>
                            <p>To become the leading online marketplace that customers trust for their shopping needs, known for quality, reliability, and innovation.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h2>Our Story</h2>
                <p>Founded in 2023, ECommerce Store began as a small family business with a simple goal: to make quality products accessible to everyone. What started as a passion project has grown into a comprehensive online marketplace serving customers worldwide.</p>
                
                <p>We believe that shopping online should be easy, secure, and enjoyable. Our team works tirelessly to curate the best products across multiple categories, from cutting-edge electronics to timeless fashion pieces, from educational books to home essentials.</p>
                
                <h3>What Sets Us Apart</h3>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                            <div>
                                <h5>Quality Guarantee</h5>
                                <p>Every product is carefully selected and tested to meet our high standards.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-shipping-fast text-success me-3 mt-1"></i>
                            <div>
                                <h5>Fast Shipping</h5>
                                <p>Free shipping on orders over $50 with quick delivery times.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-headset text-success me-3 mt-1"></i>
                            <div>
                                <h5>24/7 Support</h5>
                                <p>Our customer service team is always ready to help you.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3>Our Values</h3>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-star text-warning me-2"></i> <strong>Excellence</strong> - We strive for excellence in everything we do</li>
                            <li class="mb-2"><i class="fas fa-users text-primary me-2"></i> <strong>Customer First</strong> - Our customers are at the heart of our business</li>
                            <li class="mb-2"><i class="fas fa-handshake text-success me-2"></i> <strong>Integrity</strong> - We conduct business with honesty and transparency</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-lightbulb text-info me-2"></i> <strong>Innovation</strong> - We embrace new technologies and ideas</li>
                            <li class="mb-2"><i class="fas fa-leaf text-success me-2"></i> <strong>Sustainability</strong> - We care about our environmental impact</li>
                            <li class="mb-2"><i class="fas fa-globe text-primary me-2"></i> <strong>Community</strong> - We give back to the communities we serve</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-5 text-center">
                <h3>Ready to Shop?</h3>
                <p>Explore our wide range of products and experience the difference quality makes.</p>
                <a href="{{ url('/products') }}" class="btn btn-primary btn-lg me-3">Browse Products</a>
                <a href="{{ url('/contact') }}" class="btn btn-outline-primary btn-lg">Contact Us</a>
            </div>
        </div>
    </div>
</div>
@endsection
