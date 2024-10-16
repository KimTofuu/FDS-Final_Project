<?php
require_once($apiPath . "/interfaces/Member.php");

class member implements memberInterface {
    protected $pdo, $gm;

    public function __construct(PDO $pdo, $gm) {
        $this->pdo = $pdo;
        $this->gm = $gm;
    }

    public function SexIdentifier($data) {
        if(strtolower($data) === 'male'){
            return 1;
        }
        return 0;
    }
    public function retUser_ID() {
        try{
            $jwt = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);
            if ($jwt[0] !== 'Bearer' || empty($jwt[1])) {
                return $this->gm->responsePayload(null, 'failed', 'Invalid or Missing Token', 404);
            }
        
            $decoded = explode(".", $jwt[1]);
            if (count($decoded) !== 3) {
                return $this->gm->responsePayload(null, 'failed', 'Invalid token format', 403);
            }
        
            $payload = json_decode(base64_decode($decoded[1]));
            if (!isset($payload->token_data->User_ID)) {
                return $this->gm->responsePayload(null, 'failed', 'User_ID Invalid or Missing', 404);
            }
        
            $sql = 'SELECT COUNT(*) AS numrows FROM member_info WHERE user_id = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$payload->token_data->User_ID]);
            $rowCount = $stmt->fetchColumn();
            if ($rowCount === 0) {
                throw new InvalidArgumentException('User _ID does not exist');
            }
        
            return $payload->token_data->User_ID;
        } catch (InvalidArgumentException $e) {
            return $this->gm->responsePayload(null, 'failed', $e->getMessage(), 403);
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
    

    public function bmi($w, $h) {
        if ($h == 0) {
            throw new InvalidArgumentException('Height cannot be zero.');
        }
        $bmi = $w / pow($h / 100, 2); 
        return $bmi;
    }

    public function editInfo($data) {
        $userID = $_COOKIE['User_ID'];
        // if (empty($userID)) {
        //     $userID = $this->retUser_ID();
        // }else{
        //     return $this->gm->responsePayload(null, 'failed', 'User authentication failed', 403);
        // }

        if ($data->height == 0) {
            return $this->gm->responsePayload(null, 'failed', 'Height cannot be zero', 403);
        }

        $bmi = $this->bmi((int)$data->weight, (int)$data->height);

        $sql = 'UPDATE member_info SET name = ?, conNum = ?, eConNum = ?, address = ?, age = ?, sex = ?, gender = ?, weight = ?, height = ?, BMI = ? WHERE user_id = ?';

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->name, $data->conNum, $data->eConNum, $data->address, $data->age, $this->SexIdentifier($data->sex), $data->gender, $data->weight, $data->height, $bmi, $_COOKIE['User_ID']])) {
                return $this->gm->responsePayload(get_object_vars($data), 'success', 'Data uploaded', 200);
            } else {
                return $this->gm->responsePayload(null, 'failed', 'Upload failed', 403);
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function viewInfo() {
        $userID = $_COOKIE['User_ID'];
        // if (empty($userID)) {
        //     $userID = $this->retUser_ID();
        // }else{
        //     return $this->gm->responsePayload(null, 'failed', 'User authentication failed', 403);
        // }
        
        $sql = 'SELECT * FROM member_info WHERE user_id = ?';

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$userID])) {
                return $this->gm->responsePayload($stmt->fetch(PDO::FETCH_ASSOC), 'success', 'Data retrieved', 200);
            } else {
                return $this->gm->responsePayload(null, 'failed', 'Data retrieval failed', 403);
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
}