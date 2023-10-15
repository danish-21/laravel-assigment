<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
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
        return
            [
                'title' => 'required|unique:blogs',
                'description' => 'required',
                'tags' => 'nullable',
                'links' => 'nullable',
                'blog_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image uploads

        ];
    }
}
