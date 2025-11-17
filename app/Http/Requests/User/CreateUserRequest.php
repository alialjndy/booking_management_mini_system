<?php

namespace App\Http\Requests\User;

use App\Rules\ValidPhoneNumber;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::parseToken()->authenticate() ;
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
            'name'          =>'required|string|min:3|max:255' ,
            'email'         =>'required|email|unique:users,email',
            'password'      =>'required|string|min:8|max:255',
            'phone_number'  =>['required','string','unique:users,phone_number' , new ValidPhoneNumber]
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
            'name'         => 'User Name',
            'email'        => 'Email Address',
            'password'     => 'Password',
            'phone_number' => 'Phone Number',

        ];
    }
    public function messages(){
        return [
            'name.required'         => 'Please provide the :attribute.',
            'name.min'              => ':attribute must be at least :min characters.',
            'name.max'              => ':attribute must not exceed :max characters.',
            'email.required'        => 'Please provide the :attribute.',
            'email.email'           => 'Please provide a valid :attribute.',
            'email.unique'          => 'The :attribute is already in use.',
            'password.required'     => 'Please provide a :attribute.',
            'password.min'          => ':attribute must be at least :min characters.',
            'password.max'          => ':attribute must not exceed :max characters.',
            'phone_number.required' => 'Please provide a :attribute.',
            'phone_number.unique'   => 'The :attribute is already in use.',
        ];
    }

}
