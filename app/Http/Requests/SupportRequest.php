<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SupportRequest extends FormRequest
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
        // protected $fillable = ["support_category_id", "question", "slug", "answer", 'view'];
        return [
            'support_category_id' => ['required'],
            'question' => ['required'],
            'answer' => ['required'],
            'answer_html' => ['required'],
            'support_types' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'support_category_id.required' => 'Category is required',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => true,
        ], 422));
    }
}
