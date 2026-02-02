@extends('layouts.app')

@section('title', 'Author Details')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header head text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-user"></i> Author Information</h4>
                <div>
                    <a href="{{ route('authors.edit', $author) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('authors.destroy', $author) }}" 
                          method="POST" 
                          class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                    <a href="{{ route('authors.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $author->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Email:</strong> {{ $author->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total Books:</strong> <span class="badge bg-primary">{{ $author->books->count() }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Joined:</strong> {{ $author->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-books"></i> Books by {{ $author->name }}</h4>
            </div>
            <div class="card-body">
                @if($author->books->count() > 0)
                    <div class="row">
                        @foreach($author->books as $index => $book)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border-start border-4 border-success">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-book text-success"></i> 
                                            {{ $book->book_name }}
                                        </h5>
                                        <hr>
                                        <p class="card-text"><strong>Details:</strong></p>
                                        <p class="card-text text-muted">{{ $book->book_details }}</p>
                                        
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <p class="mb-1">
                                                    <i class="fas fa-file-alt text-primary"></i> 
                                                    <strong>Pages:</strong> {{ $book->page_count }}
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1">
                                                    <i class="fas fa-calendar text-info"></i> 
                                                    <strong>Added:</strong> {{ $book->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>

                                        @if($book->book_file)
                                            <div class="mt-3">
                                                <a href="{{ Storage::url($book->book_file) }}" 
                                                   class="btn btn-sm btn-outline-success" 
                                                   target="_blank">
                                                    <i class="fas fa-download"></i> Download Book File
                                                </a>
                                            </div>
                                        @else
                                            <div class="mt-3">
                                                <span class="badge bg-secondary">No file uploaded</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No books found for this author</h5>
                        <p class="text-muted">Add books by editing the author</p>
                        <a href="{{ route('authors.edit', $author) }}" class="btn head">
                            <i class="fas fa-plus"></i> Add Books
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