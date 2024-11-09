<?php
require_once($apiPath . "/interfaces/Member.php");

class member implements memberInterface {
    protected $pdo, $gm;

    public function __construct(\PDO $pdo, ResponseMethodsProj $gm) {
        $this->pdo = $pdo;
        $this->gm = $gm;
    }

    public function SexIdentifier($data) {
        if(strtolower($data) === 'male'){
            return 1;
        }
        return 0;
    }

    public function bmi($w, $h) {
        if ($h == 0) {
            throw new InvalidArgumentException('Height cannot be zero.');
        }
        $bmi = $w / pow($h / 100, 2); 
        return $bmi;
    }

    public function editInfo($data) {
        $userID = $this->gm->getIDFromToken();

        if ($data->height == 0) {
            return $this->gm->responsePayload(null, 'failed', 'Height cannot be zero', 403);
        }

        $bmi = $this->bmi((int)$data->weight, (int)$data->height);

        $sql = 'UPDATE member_info SET name = ?, conNum = ?, eConNum = ?, address = ?, age = ?, sex = ?, gender = ?, weight = ?, height = ?, BMI = ? WHERE user_id = ?';

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->name, $data->conNum, $data->eConNum, $data->address, $data->age, $this->SexIdentifier($data->sex), $data->gender, $data->weight, $data->height, $bmi, $userID])) {
                return $this->gm->responsePayload(get_object_vars($data), 'success', 'Data uploaded', 200);
            } else {
                return $this->gm->responsePayload(null, 'failed', 'Upload failed', 403);
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    
    public function viewInfo() {
        $userID = $this->gm->getIDFromToken();
        if (!$userID) {
            return $this->gm->responsePayload(null, 'error', 'Invalid user ID', 400);
        }

        $sql = "SELECT * FROM member_info WHERE user_id = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$userID])) {
                $data = $stmt->fetchAll();
                if ($stmt->rowCount() > 0) {
                    return $this->gm->responsePayload($data, 'success', 'User data retrieved successfully.', 200);
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'User data does not exist.', 404);
                }
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function setAlarm($data){
        $userID = $this->gm->getIDFromToken();

        $sql = 'INSERT INTO gymalarm(User_ID, day, time) VALUES(?, ?, ?)';
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$userID, $data->day, $data->time])) {
                return $this->gm->responsePayload($data, 'success', 'Alarm or reminder set', 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Alarm or reminder not set', 403);
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function setSession($data){
        $userID = $this->gm->getIDFromToken();

        $sql = 'INSERT INTO gymsession(User_ID, date, time, Coach_ID) VALUES(?, ?, ?, ?)';
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$userID, $data->date, $data->time, $data->Coach_ID])) {
                return $this->gm->responsePayload($data, 'success', 'Alarm or reminder set', 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Alarm or reminder not set', 403);
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
}