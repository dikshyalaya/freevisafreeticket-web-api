<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $authuser = Auth::user();
        return $authuser!=null;
        //return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "new_password" => "required",
            "confirm_password" => 'required|same:new_password'
       ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
          ]));
    }

    public function messages() //OPTIONAL
    {
        return [
            'new_password.required' => 'Password is required',
            'confirm_password.required' => 'Confirm Password is not correct',
            'confirm_password.same' => 'Confirm Password is does not match the new password'
        ];
    }
    
}
