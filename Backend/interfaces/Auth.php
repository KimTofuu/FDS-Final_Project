<?php

interface AuthInterface{
    public function login($sql, $data, $userType);
    public function logout();
    public function adminLogin($data);
    public function memLogin($data);
    public function coachLogin($data); 
    public function adminReg($data);
}
