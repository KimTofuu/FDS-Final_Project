<?php

class middleware{
    protected $header, $auth;

    public function __construct(auth $auth){
        $this->header = apache_request_headers();
        $this->auth = $auth;
    }

    public function isAuthenticated(){
        if(isset($this->header['Authorization'])){
            $data = explode(' ', $this->header['Authorization']);

            if($data[0] !== 'Bearer') return false;
            $payload = $this->auth->verifyToken($data[1]);

            if(!$payload['is_valid']) return false;

            return true;
        }

        return false;
    }
}