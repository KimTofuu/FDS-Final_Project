<?php
require_once($apiPath . "/interfaces/Member.php");

class member implements memberInterface {
    protected $pdo, $gm;

    public function __construct(\PDO $pdo, ResponseMethodsProj $gm) {
        $this->pdo = $pdo;
        $this->gm = $gm;
    }

    // private function getIDFromToken(){
    //     if (isset($_COOKIE['Authorization'])) {
    //         $jwt = explode(' ', $_COOKIE['Authorization']);
            
    //         if ($jwt[0] === 'Bearer' && isset($jwt[1])) {
    //             $token = $jwt[1];
                
    //             $decoded = explode(".", $token);
                
    //             $payload = json_decode(base64_decode($decoded[1]));
                
    //             $signature = hash_hmac('sha256', $decoded[0] . "." . $decoded[1], SECRET_KEY, true);
    //             $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
                
    //             if ($base64UrlSignature === $decoded[2]) {
    //                 if (isset($payload->token_data->User_ID)) {
    //                     $this->userID = $payload->token_data->User_ID;
    //                 } else {
    //                     return $this->gm->responsePayload(null, 'error', 'User_ID not found in the token', 404);
    //                 }
    //             } else {
    //                 return $this->gm->responsePayload(null, 'error', 'Invalid token signature', 401);
    //             }
    //         } else {
    //             return $this->gm->responsePayload(null, 'error', 'Invalid token format', 401);
    //         }
    //     } else {
    //         return $this->gm->responsePayload(null, 'error', 'Cookie not found', 404);
    //     }
    // }


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

    
    //comment out na muna, di ko talaga mahanap eh

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
}