<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required|integer|exists:blog_categories,id',
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|min:3|max:200',
            'slug' => 'max:200',
            'excerpt' => 'max:200',
            'content' => 'required|max:10000',
            'status' => 'required|integer',

        ];
    }
}
