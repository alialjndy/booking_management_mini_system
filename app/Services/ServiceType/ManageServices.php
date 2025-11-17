<?php
namespace App\Services\ServiceType;

use App\Models\ServiceType;
use Exception;

class ManageServices{
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
            $service = ServiceType::create($data);
            return $this->getSuccess(201, $service);
        }catch(Exception $e){
            return $this->getFailed($e->getCode(), $e->getMessage());
        }
    }
    public function update(array $data , ServiceType $serviceType){
        try{
            $serviceType->update($data);
            return $this->getSuccess(200, $serviceType->refresh());
        }catch(Exception $e){
            return $this->getFailed($e->getCode(), $e->getMessage());
        }
    }
}
