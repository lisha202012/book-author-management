<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:authors,email',
            'number_of_books' => 'required|integer|min:1|max:10',
            'books.*.book_name' => 'required|string|max:255',
            'books.*.book_details' => 'required|string',
            'books.*.page_count' => 'required|integer|min:1',
            'books.*.book_file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Author name is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already registered',
            'books.*.book_name.required' => 'Book name is required',
            'books.*.book_details.required' => 'Book details are required',
            'books.*.page_count.required' => 'Page count is required',
            'books.*.page_count.min' => 'Page count must be at least 1',
            'books.*.book_file.mimes' => 'Book file must be PDF, DOC, DOCX, or TXT',
            'books.*.book_file.max' => 'Book file size must not exceed 10MB',
        ];
    }
}