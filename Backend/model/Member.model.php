<?php

class member implements memberInterface{

    protected $pdo, $gm;

    public function __construct(PDO $pdo, $gm){
        $this->pdo = $pdo;
        $this->gm = $gm;
    }

    public function bmi($w, $h){
        $bmi = $w / pow($h, 2);
        return $bmi;
    }

    public function editInfo($data){
        $name = $data->name;
        $contactNum = $data->conNum;
        $emergencyConNum = $data->eConNum;
        $address = $data->address;
        $age = $data->age;
        $sex = $data->sex;
        $gender = $data->gender;
        $weight = $data->weight;
        $height = $data->height;
        $bmi = $this->bmi($weight, $height);

        $sql = 'INSERT INTO member_info(name, conNum, eConNum, address, age, sex, gender, weigth, height, BMI) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        try{
            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute([$data->name, $data->conNum, $data->eConName, $data->address, $data->age, $data->sex, $data->gender, $data->weight, $data->height, $bmi])){
                return $this->gm->responsePayload($data, 'success', 'Data uploaded', 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Upload failed', 403);
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

}