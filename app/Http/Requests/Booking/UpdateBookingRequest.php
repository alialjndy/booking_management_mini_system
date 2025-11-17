<?php

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user && $user->hasAnyRole(['admin', 'staff']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name'     => 'nullable|string|max:255',
            'phone_number'      => 'nullable|string|max:50',
            'booking_date'      => 'nullable|date|after_or_equal:today',
            'service_type_id'   => 'nullable|exists:service_types,id',
            'notes'             => 'nullable|string',
            'status'            => 'nullable|in:pending,confirmed,cancelled',
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
            'customer_name'   => 'Customer Name',
            'phone_number'    => 'Phone Number',
            'booking_date'    => 'Booking Date',
            'service_type_id' => 'Service Type',
            'notes'           => 'Notes',
            'status'          => 'Booking Status',
        ];
    }
    public function messages(){
        return [
            'after_or_equal' => 'The :attribute must be today or in the future.',
            'exists'         => 'The selected :attribute is invalid.',
            'in'             => 'The selected :attribute is invalid.',
            'date'           => 'The :attribute must be a valid date.',
        ];
    }
}
