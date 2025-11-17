<?php

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateBookingRequest extends FormRequest
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
            'customer_name'     => 'required|string|max:255',
            'phone_number'      => 'required|string|max:50',
            'booking_date'      => 'required|date',
            'service_type_id'   => 'required|exists:service_types,id',
            'notes'             => 'nullable|string',
            'status'            => 'required|in:pending,confirmed,cancelled',
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
            'customer_name'    => 'customer name',
            'phone_number'     => 'phone number',
            'booking_date'     => 'booking date',
            'service_type_id'  => 'service type',
            'notes'            => 'notes',
            'status'           => 'status',
        ];
    }
    public function messages()
    {
        return [
            'customer_name.required'    => 'The customer name field is required.',
            'phone_number.required'     => 'The phone number field is required.',

            'booking_date.required'     => 'The booking date field is required.',
            'booking_date.date'         => 'The booking date must be a valid date.',

            'service_type_id.required'  => 'The service type field is required.',
            'service_type_id.exists'    => 'The selected service type is invalid.',

            'status.required'           => 'The status field is required.',
            'status.in'                 => 'The status must be one of: pending, confirmed, or cancelled.',
        ];
    }

}
