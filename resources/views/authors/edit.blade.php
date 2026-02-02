@extends('layouts.app')

@section('title', 'Edit Author')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Author & Books</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('authors.update', $author) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2"><i class="fas fa-user"></i> Author Details</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Author Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $author->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $author->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2"><i class="fas fa-book"></i> Book Information</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Note: Changing the number of books will replace all existing books.
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="number_of_books" class="form-label">Number of Books <span class="text-danger">*</span></label>
                                <select class="form-select @error('number_of_books') is-invalid @enderror" 
                                        id="number_of_books" 
                                        name="number_of_books" 
                                        onchange="generateBookFields()" 
                                        required>
                                    <option value="">Select Number</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('number_of_books', $author->books->count()) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('number_of_books')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div id="books-container"></div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('authors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Author & Books
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const existingBooks = @json($author->books);

function generateBookFields() {
    const numberOfBooks = document.getElementById('number_of_books').value;
    const container = document.getElementById('books-container');
    container.innerHTML = '';

    for (let i = 0; i < numberOfBooks; i++) {
        const existingBook = existingBooks[i] || {};
        
        const bookHtml = `
            <div class="card mb-3 book-card">
                <div class="card-header bg-light">
                    <strong><i class="fas fa-book-open"></i> Book ${i + 1}</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Book Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   name="books[${i}][book_name]" 
                                   value="${existingBook.book_name || ''}" 
                                   required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Page Count <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control" 
                                   name="books[${i}][page_count]" 
                                   value="${existingBook.page_count || ''}" 
                                   min="1" 
                                   required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Book Details <span class="text-danger">*</span></label>
                            <textarea class="form-control" 
                                      name="books[${i}][book_details]" 
                                      rows="3" 
                                      required>${existingBook.book_details || ''}</textarea>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Upload Book File (PDF, DOC, DOCX, TXT - Max 10MB)</label>
                            ${existingBook.book_file ? `<div class="alert alert-info py-2"><small><i class="fas fa-file"></i> Current file: ${existingBook.book_file.split('/').pop()}</small></div>` : ''}
                            <input type="file" 
                                   class="form-control" 
                                   name="books[${i}][book_file]" 
                                   accept=".pdf,.doc,.docx,.txt">
                            <small class="text-muted">Leave empty to keep existing file (if any)</small>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += bookHtml;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    generateBookFields();
});
</script>
@endpush