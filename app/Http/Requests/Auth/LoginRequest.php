<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email'     => 'required|email',
            'password'  => 'required|string|min:8'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => 'failed',
                'message' => 'Validation failed. Please check your input.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
    public function attributes()
    {
        return [
            'email'     => 'User Email',
            'password'  =>'User Password'
        ];
    }
    public function messages(){
        return [
            'email.required'    => 'Please provide your :attribute.',
            'email.email'       => 'The :attribute must be a valid email address.',
            'password.required' => 'Please provide your :attribute.',
            'password.min'      => ':attribute must be at least :min characters long.',
        ];
    }
}
