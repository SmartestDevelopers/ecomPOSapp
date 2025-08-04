@extends('layouts.admin')

@section('title', 'Edit Category - ' . $category->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Category - {{ $category->name }}</h3>
                    <div>
                        <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Categories
                        </a>
                    </div>
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
                            <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <strong>Category Name <span class="text-danger">*</span></strong>
                                    </label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $category->name) }}" 
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
                                           value="{{ old('slug', $category->slug) }}" 
                                           placeholder="category-slug" 
                                           required maxlength="255">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        URL-friendly version of the name. Use lowercase letters, numbers, and hyphens only.
                                        <br><strong>Warning:</strong> Changing the slug will change the category URL.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="form-label">
                                        <strong>Description</strong>
                                    </label>
                                    <textarea name="description" id="description" rows="4" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Enter category description...">{{ old('description', $category->description) }}</textarea>
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
                                           value="{{ old('meta_title', $category->meta_title) }}" 
                                           placeholder="SEO meta title..." 
                                           maxlength="255">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Optional. Title tag for search engines (recommended: 50-60 characters).
                                        <span id="meta_title_count" class="ml-2">0/255</span>
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="meta_description" class="form-label">
                                        <strong>Meta Description (SEO)</strong>
                                    </label>
                                    <textarea name="meta_description" id="meta_description" rows="3" 
                                              class="form-control @error('meta_description') is-invalid @enderror"
                                              placeholder="SEO meta description...">{{ old('meta_description', $category->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Optional. Description for search engines (recommended: 150-160 characters).
                                        <span id="meta_desc_count" class="ml-2">0/500</span>
                                    </small>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Category
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Category Info and Tips -->
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle text-info"></i> Current Category Info
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <strong>ID:</strong> #{{ $category->id }}
                                        </li>
                                        <li class="mb-2">
                                            <strong>Current URL:</strong>
                                            <br><small><code>{{ url('/categories/' . $category->slug) }}</code></small>
                                        </li>
                                        <li class="mb-2">
                                            <strong>Products:</strong> {{ $category->products_count ?? 0 }}
                                        </li>
                                        <li class="mb-2">
                                            <strong>Created:</strong> {{ \Carbon\Carbon::parse($category->created_at)->format('M d, Y') }}
                                        </li>
                                        <li class="mb-0">
                                            <strong>Last Updated:</strong> {{ \Carbon\Carbon::parse($category->updated_at)->format('M d, Y') }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card bg-warning text-dark mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-exclamation-triangle"></i> Important Note
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="card-text mb-0">
                                        <strong>Changing the slug will update the category URL.</strong> 
                                        This may affect SEO rankings and existing bookmarks. 
                                        Make sure to set up proper redirects if needed.
                                    </p>
                                </div>
                            </div>

                            @if($category->products_count > 0)
                            <div class="card bg-info text-white mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-boxes"></i> Associated Products
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="card-text mb-2">
                                        This category has <strong>{{ $category->products_count }}</strong> associated products.
                                    </p>
                                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-sm btn-light">
                                        View Products
                                    </a>
                                </div>
                            </div>
                            @endif

                            <div class="card bg-light mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-lightbulb text-warning"></i> SEO Tips
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0 small">
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success"></i>
                                            Keep meta title under 60 characters
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success"></i>
                                            Meta description should be 150-160 characters
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success"></i>
                                            Use relevant keywords naturally
                                        </li>
                                        <li class="mb-0">
                                            <i class="fas fa-check text-success"></i>
                                            Make descriptions compelling for users
                                        </li>
                                    </ul>
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
    // Auto-generate slug from name (but allow manual override)
    let slugManuallyEdited = false;
    
    $('#slug').on('input', function() {
        slugManuallyEdited = true;
    });

    $('#name').on('input', function() {
        if (!slugManuallyEdited) {
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

    $('#meta_title').on('input', function() {
        updateCharCount('#meta_title', '#meta_title_count', 255);
    });

    $('#meta_description').on('input', function() {
        updateCharCount('#meta_description', '#meta_desc_count', 500);
    });

    // Initialize counters
    updateCharCount('#meta_title', '#meta_title_count', 255);
    updateCharCount('#meta_description', '#meta_desc_count', 500);

    // Form submission confirmation for slug changes
    $('form').on('submit', function(e) {
        const originalSlug = '{{ $category->slug }}';
        const newSlug = $('#slug').val();
        
        if (originalSlug !== newSlug) {
            if (!confirm('You are changing the category slug. This will change the category URL. Are you sure you want to continue?')) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>
@endpush
