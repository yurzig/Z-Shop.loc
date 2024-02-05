<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class ReviewUpdateRequest extends FormRequest
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
            'post_id' => 'required|integer|exists:blog_posts,id',
            'user_id' => 'required|integer|exists:users,id',
            'rating' => 'nullable|integer',
            'comment' => 'string|max:2000',
            'response' => 'nullable|string',
            'status' => 'integer',
            'editor' => 'integer',
        ];
    }
}
