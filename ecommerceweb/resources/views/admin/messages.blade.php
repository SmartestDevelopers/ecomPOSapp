@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Contact Messages</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5>All Messages</h5>
                </div>
                <div class="card-body">
                    @if(isset($messages) && $messages->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>No messages yet</h5>
                            <p class="text-muted">Contact messages will appear here when customers send them.</p>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>Contact Messages Feature</h5>
                            <p class="text-muted">The contact messages table hasn't been created yet. This feature will be available once the contact form is implemented.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
