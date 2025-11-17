<?php
namespace App\Services\Booking;

use App\Models\Booking;
use Exception;

class BookingService{
    private function getFailed($code , $error){
        return [
            'status' => 'failed',
            'error' => $error ,
            'code' => $code
        ];
    }
    private function getSuccess($code , $data){
        return [
            'status' => 'success',
            'data' => $data ,
            'code' => $code
        ];
    }
    public function create(array $data){
        try{
            $booking = Booking::create($data);
            return $this->getSuccess(201 , $booking);
        }catch(Exception $e){
            return $this->getFailed($e->getCode() , $e->getMessage());
        }
    }
    public function update(array $data , Booking $booking){
        try{
            $booking->update($data);
            return $this->getSuccess(200 , $booking->refresh());
        }catch(Exception $e){
            return $this->getFailed($e->getCode() , $e->getMessage());
        }
    }
}
