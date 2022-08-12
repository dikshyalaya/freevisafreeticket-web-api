<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
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
        if(request()->isMethod('post')){
            return [
                'title' => ['required', 'unique:trainings,title'],
            ];
        } else if(request()->isMethod('put') || request()->isMethod('patch')){
            return [
                'title' => ['required', 'unique:trainings,title,'.$this->id],
            ];
        }
    }
}
