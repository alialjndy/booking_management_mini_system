<?php
namespace App\Services\Auth;

use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService{
    /**
     * Build a success response for authentication operations.
     */
    private function successResponse(string $message, ?string $token = null): array
    {
        return [
            'status'  => 'success',
            'message' => $message,
            'token'   => $token,
        ];
    }

    /**
     * Build a failed response.
     */
    private function failedResponse(string $status, int $code, $errors = null): array
    {
        return [
            'status' => $status,
            'code'   => $code,
            'errors' => $errors,
        ];
    }
    public function login(array $credentials): array
    {
        try {
            // Attempt to authenticate and generate JWT token
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->failedResponse('failed',401,'Invalid credentials. Please try again.');
            }

            return $this->successResponse('Login successfully.', $token);

        } catch (Exception $e) {

            // Catch unexpected authentication or token generation errors
            return $this->failedResponse('failed',$e->getCode() ?: 500,$e->getMessage());
        }
    }
}
