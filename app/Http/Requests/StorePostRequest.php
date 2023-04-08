<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            //
            'title' => ['bail', 'required', 'unique:posts,title'],
            'body' => ['required'],
            'coverImage' => 'image|nullable|max:1999',
        ];
    }

    // /**
    //  * Get custom attributes for validator errors.
    //  *
    //  * @return array
    //  */
    // public function attributes()
    // {
    //     return [
    //         'cover_image' => 'coverImage',
    //     ];
    // }
}
