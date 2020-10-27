<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'image' => 'required',
            'message' => 'required',
            'area' => 'required|string',
            'transport' => 'required|integer',
            'count' => 'required|integer',
            'fee' => 'required|integer',
            'start_hour' => 'required|integer',
            'start_min' => 'required|integer',
            'end_hour' => 'required|integer',
            'end_min' => 'required|integer',
        ];
    }
}