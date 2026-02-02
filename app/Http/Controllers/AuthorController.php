<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{

    public function index()
    {
        $authors = Author::withCount('books')->latest()->paginate(10);
        return view('authors.index', compact('authors'));
    }


    public function create()
    {
        return view('authors.create');
    }

    public function store(StoreAuthorRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $author = Author::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->has('books')) {
                foreach ($request->books as $bookData) {
                    $bookFile = null;
                    
                    if (isset($bookData['book_file']) && $bookData['book_file']) {
                        $file = $bookData['book_file'];
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $bookFile = $file->storeAs('books', $fileName, 'public');
                    }

                    Book::create([
                        'author_id' => $author->id,
                        'book_name' => $bookData['book_name'],
                        'book_details' => $bookData['book_details'],
                        'page_count' => $bookData['page_count'],
                        'book_file' => $bookFile,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('authors.index')
                ->with('success', 'Author and books created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating author: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Author $author)
    {
        $author->load('books');
        return view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        $author->load('books');
        return view('authors.edit', compact('author'));
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        DB::beginTransaction();
        
        try {
            $author->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            foreach ($author->books as $book) {
                if ($book->book_file) {
                    Storage::disk('public')->delete($book->book_file);
                }
                $book->delete();
            }

            if ($request->has('books')) {
                foreach ($request->books as $bookData) {
                    $bookFile = null;
                    
                    if (isset($bookData['book_file']) && $bookData['book_file']) {
                        $file = $bookData['book_file'];
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $bookFile = $file->storeAs('books', $fileName, 'public');
                    }

                    Book::create([
                        'author_id' => $author->id,
                        'book_name' => $bookData['book_name'],
                        'book_details' => $bookData['book_details'],
                        'page_count' => $bookData['page_count'],
                        'book_file' => $bookFile,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('authors.index')
                ->with('success', 'Author and books updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating author: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function destroy(Author $author)
    {
        try {
            foreach ($author->books as $book) {
                if ($book->book_file) {
                    Storage::disk('public')->delete($book->book_file);
                }
            }
            
            $author->delete();
            
            return redirect()->route('authors.index')
                ->with('success', 'Author deleted successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting author: ' . $e->getMessage());
        }
    }
}