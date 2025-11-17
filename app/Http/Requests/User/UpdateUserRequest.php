<?php

namespace App\Http\Requests\User;

use App\Rules\ValidPhoneNumber;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user && $user->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          =>'nullable|string|min:3|max:255' ,
            'email'         =>'nullable|email|unique:users,email',
            'password'      =>'nullable|string|min:8|max:255',
            'phone_number'  =>['nullable','string','unique:users,phone_number', new ValidPhoneNumber]
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
    public function attributes(){
        return [
            'name'         => 'User Name',
            'email'        => 'Email Address',
            'password'     => 'Password',
            'phone_number' => 'Phone Number',
        ];
    }
    public function messages(){
        return [
            'name.min'      => ':attribute must be at least :min characters.',
            'name.max'      => ':attribute must not exceed :max characters.',
            'email.email'   => 'Please provide a valid :attribute.',
            'email.unique'  => 'The :attribute is already in use.',
            'password.min'  => ':attribute must be at least :min characters.',
            'password.max'  => ':attribute must not exceed :max characters.',
            'phone_number.unique' => 'The :attribute is already in use.',
        ];
    }
}
