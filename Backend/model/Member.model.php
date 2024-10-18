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
    public function getIDFromToken(){
        // Check if the Authorization cookie is set
        if (isset($_COOKIE['Authorization'])) {
            // Split the cookie value to extract the token (format: Bearer <JWT>)
            $jwt = explode(' ', $_COOKIE['Authorization']);
            
            // Check if the token is in the expected format (Bearer <token>)
            if ($jwt[0] === 'Bearer' && isset($jwt[1])) {
                // Extract the JWT token
                $token = $jwt[1];
                
                // Split the token into its components (header, payload, signature)
                $decoded = explode(".", $token);
                
                // Decode the payload (base64 decoding)
                $payload = json_decode(base64_decode($decoded[1]));
                
                // Verify the signature (optional but recommended)
                $signature = hash_hmac('sha256', $decoded[0] . "." . $decoded[1], SECRET_KEY, true);
                $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
                
                if ($base64UrlSignature === $decoded[2]) {
                    // Token is valid; now check if User_ID exists in the payload
                    if (isset($payload->token_data->User_ID)) {
                        // Return the User_ID
                        return $payload->token_data->User_ID;
                    } else {
                        return null;  // User_ID not found in the token
                    }
                } else {
                    return null;  // Invalid token signature
                }
            } else {
                return null;  // Invalid token format
            }
        } else {
            return null;  // Cookie not set
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
        $userID = $this->getIDFromToken();

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
        $userID = $this->getIDFromToken();
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