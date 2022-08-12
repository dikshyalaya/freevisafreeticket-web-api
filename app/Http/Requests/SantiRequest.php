<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SantiRequest extends FormRequest
{
    public $validator = null;
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
        if(request()->isMethod('post')){
            return [
                'title' => ['required', 'unique:about_santis,title'],
                'feature_image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:4096'],
            ];
        } else if(request()->isMethod('put') || request()->isMethod('patch')){
            return [
                'title' => ['required', 'unique:about_santis,title,'.$this->id],
                'feature_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:4096'],
            ];
        }

    }

    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
