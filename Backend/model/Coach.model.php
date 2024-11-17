<?php
require_once($apiPath . '/interfaces/Coach.php');
class coach implements coachInterface{
    protected $pdo, $gm;
    

    public function __construct(\PDO $pdo, ResponseMethodsProj $gm){
        $this->pdo = $pdo;
        $this->gm = $gm;
    }

    public function seeMemDet(){
        $getDeets = 'SELECT m.Username,  ';
    }   

    public function sendMessage($data){

    }

    public function getAllClients(){
        $getClients = 'SELECT m.User_ID, m.Username, n.name, n.conNum, 
            n.age, n.sex, n.bodyType, n.activityLevel, n.weight, n.height, 
            n.BMI 
            FROM member m
            JOIN coach_classes cc ON m.User_ID = cc.user_id
            JOIN member_info n ON m.User_ID = n.user_id
            WHERE cc.coach_id = ?';

        
    }
}