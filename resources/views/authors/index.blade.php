@extends('layouts.app')

@section('title', 'Book & Author Management System')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>   
<div class="row">
    <div class="col-12">
        <div class="card"> 
            <div class="card-header text-white d-flex justify-content-between align-items-center head">
                <h4 class="mb-0"><i class="fas fa-users"></i> Authors List</h4>
                <a href="{{ route('authors.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Add New Author
                </a>
            </div>
            <div class="card-body">
                @if($authors->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Number of Books</th>
                                    <th>Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($authors as $author)
                                    <tr>
                                        <td>{{ $loop->iteration + ($authors->currentPage() - 1) * $authors->perPage() }}</td>
                                        <td><strong>{{ $author->name }}</strong></td>
                                        <td>{{ $author->email }}</td>
                                        <td>
                                            <span class="badge head">{{ $author->books_count }} Book(s)</span>
                                        </td>
                                        <td>{{ $author->created_at->format('M d, Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('authors.show', $author) }}" 
                                               class="btn btn-sm btn-info btn-action" 
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('authors.edit', $author) }}" 
                                               class="btn btn-sm btn-warning btn-action" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        <form action="{{ route('authors.destroy', $author) }}" 
                                            method="POST" 
                                            class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger btn-action" 
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $authors->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No authors found</h5>
                        <p class="text-muted">Start by adding your first author</p>
                        <a href="{{ route('authors.create') }}" class="btn head">
                            <i class="fas fa-plus"></i> Add Author
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "This author and all associated books will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection