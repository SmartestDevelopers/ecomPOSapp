@extends('layouts.admin')

@section('title', 'Create New Category')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Create New Category</h3>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
                </div>
                
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <form method="POST" action="{{ route('admin.categories.store') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <strong>Category Name <span class="text-danger">*</span></strong>
                                    </label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" 
                                           placeholder="Enter category name..." 
                                           required maxlength="255">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        The category name should be unique and descriptive.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="slug" class="form-label">
                                        <strong>Slug <span class="text-danger">*</span></strong>
                                    </label>
                                    <input type="text" name="slug" id="slug" 
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           value="{{ old('slug') }}" 
                                           placeholder="category-slug" 
                                           required maxlength="255">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        URL-friendly version of the name. Use lowercase letters, numbers, and hyphens only.
                                        <br>Leave blank to auto-generate from the name.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="form-label">
                                        <strong>Description</strong>
                                    </label>
                                    <textarea name="description" id="description" rows="4" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Enter category description...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Optional description to help customers understand what products this category contains.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="meta_title" class="form-label">
                                        <strong>Meta Title (SEO)</strong>
                                    </label>
                                    <input type="text" name="meta_title" id="meta_title" 
                                           class="form-control @error('meta_title') is-invalid @enderror" 
                                           value="{{ old('meta_title') }}" 
                                           placeholder="SEO meta title..." 
                                           maxlength="255">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Optional. Title tag for search engines (recommended: 50-60 characters).
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="meta_description" class="form-label">
                                        <strong>Meta Description (SEO)</strong>
                                    </label>
                                    <textarea name="meta_description" id="meta_description" rows="3" 
                                              class="form-control @error('meta_description') is-invalid @enderror"
                                              placeholder="SEO meta description...">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Optional. Description for search engines (recommended: 150-160 characters).
                                    </small>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Create Category
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tips Card -->
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-lightbulb text-warning"></i> Tips
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success"></i>
                                            <strong>Category Name:</strong> Choose a clear, descriptive name
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success"></i>
                                            <strong>Unique Slug:</strong> Must be unique across all categories
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success"></i>
                                            <strong>SEO Meta:</strong> Helps with search engine visibility
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success"></i>
                                            <strong>Description:</strong> Helps customers understand the category
                                        </li>
                                        <li class="mb-0">
                                            <i class="fas fa-info text-info"></i>
                                            Categories organize your products for better navigation
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card bg-info text-white mt-3">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-info-circle"></i> Auto-generation
                                    </h6>
                                    <p class="card-text mb-0">
                                        If you leave the slug field empty, it will be automatically generated from the category name.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-generate slug from name
    $('#name').on('input', function() {
        if ($('#slug').val() === '') {
            let slug = $(this).val()
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            $('#slug').val(slug);
        }
    });

    // Clean slug input
    $('#slug').on('input', function() {
        let slug = $(this).val()
            .toLowerCase()
            .replace(/[^a-z0-9-]/g, '')
            .replace(/-+/g, '-')
            .trim('-');
        $(this).val(slug);
    });

    // Character count for meta fields
    function updateCharCount(fieldId, countId, maxLength) {
        const field = $(fieldId);
        const counter = $(countId);
        const currentLength = field.val().length;
        counter.text(`${currentLength}/${maxLength}`);
        
        if (currentLength > maxLength * 0.9) {
            counter.addClass('text-warning');
        } else {
            counter.removeClass('text-warning');
        }
        
        if (currentLength > maxLength) {
            counter.addClass('text-danger').removeClass('text-warning');
        } else {
            counter.removeClass('text-danger');
        }
    }

    // Add character counters
    $('#meta_title').after('<small class="form-text text-muted"><span id="meta_title_count">0/255</span></small>');
    $('#meta_description').after('<small class="form-text text-muted"><span id="meta_desc_count">0/500</span></small>');

    $('#meta_title').on('input', function() {
        updateCharCount('#meta_title', '#meta_title_count', 255);
    });

    $('#meta_description').on('input', function() {
        updateCharCount('#meta_description', '#meta_desc_count', 500);
    });

    // Initialize counters
    updateCharCount('#meta_title', '#meta_title_count', 255);
    updateCharCount('#meta_description', '#meta_desc_count', 500);
});
</script>
@endpush
