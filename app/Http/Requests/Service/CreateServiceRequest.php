<?php

namespace App\Http\Requests\Service;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateServiceRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string'
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
            'name'          => 'Service Name',
            'description'   => 'Service Description'
        ];
    }
    public function messages()
    {
        return [
            'name.required'        => 'The name field is required.',
            'name.string'          => 'The name must be a valid string.',
            'name.max'             => 'The name may not be greater than 255 characters.',

            'description.string'   => 'The description must be a valid string.',
        ];
    }
}
