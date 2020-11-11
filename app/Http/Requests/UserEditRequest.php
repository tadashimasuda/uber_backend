<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'email' => ['email','required', Rule::unique('users')->ignore($this->user()->id)],
            'name' => 'required',
            'password' => 'required|confirmed',
            'twitter_id' => 'nullable',
            'image' => 'nullable|string',
            'transport' => 'required|integer' 
        ];
    }
}
