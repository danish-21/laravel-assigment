<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            [
                'title' => 'nullable|unique:blogs,title,',
                'description' => 'nullable|min:10',
                'tags' => 'nullable',
                'links.*.title' => 'nullable|string',
                'links.*.url' => 'nullable|url',
                'blog_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]
        ];
    }
}
