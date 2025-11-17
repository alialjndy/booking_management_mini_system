<?php
namespace App\Services\User;

use App\Models\User;
use Exception;

class UserService{
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
            $user = User::create($data);
            return $this->getSuccess(201 , $user);
        }catch(Exception $e){
            return $this->getFailed($e->getCode() , $e->getMessage());
        }
    }
    public function update(array $data , User $user){
        try{
            $user->update($data);
            return $this->getSuccess(200 , $user->refresh());
        }catch(Exception $e){
            return $this->getFailed($e->getCode() , $e->getMessage());
        }
    }
}
