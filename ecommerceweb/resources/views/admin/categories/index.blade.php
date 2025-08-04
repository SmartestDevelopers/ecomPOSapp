@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Categories Management</h3>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Category
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- Search and Filters -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.categories.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search categories..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right">
                                <span class="text-muted">Total Categories: {{ $categories->total() }}</span>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Categories Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th width="120">Products Count</th>
                                    <th width="150">Created Date</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        <strong>{{ $category->name }}</strong>
                                    </td>
                                    <td>
                                        <code>{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        @if($category->description)
                                            {{ Str::limit($category->description, 60) }}
                                        @else
                                            <span class="text-muted">No description</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($category->products_count > 0)
                                            <span class="badge badge-info">{{ $category->products_count }}</span>
                                        @else
                                            <span class="badge badge-secondary">0</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($category->created_at)->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.categories.show', $category->id) }}" 
                                               class="btn btn-sm btn-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($category->products_count == 0)
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-secondary" 
                                                        title="Cannot delete category with products" disabled>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                                            <p>No categories found.</p>
                                            @if(request('search'))
                                                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-primary">
                                                    Clear Search
                                                </a>
                                            @else
                                                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-plus"></i> Create First Category
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($categories->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $categories->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the category <strong id="categoryName"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteCategory(categoryId, categoryName) {
    $('#categoryName').text(categoryName);
    $('#deleteForm').attr('action', `/admin/categories/${categoryId}`);
    $('#deleteModal').modal('show');
}
</script>
@endpush
