<?php

require_once($apiPath . '/interfaces/Auth.php');

class Auth implements AuthInterface{
    
    protected $pdo,$gm;

    public function __construct(\PDO $pdo, ResponseMethodsProj $gm)
    {
        $this->pdo = $pdo;
        $this->gm = $gm;
    }

    public function adminReg($data){
        $checkRows = 'SELECT COUNT(*) AS numrows FROM adminauth';
        $sql = 'INSERT INTO adminauth(Username, Password) VALUES(?, ?)';

        try{
            $stmtCheckR = $this->pdo->prepare($checkRows);
            $stmtCheckR->execute();
            $rowCount = $stmtCheckR->fetchColumn();

            if ($rowCount >= 1){
                return $this->gm->responsePayload(null, "failed", "Admin account already exists", 403);
            }
        

            if (empty($data->Username) || empty($data->Password)) {
                return $this->gm->responsePayload(null, 'failed', 'Fill up all required fields.', 400);
            }

            $option = [
                "cost" => 11 
            ];
            $hashedPass = password_hash($data->Password, PASSWORD_BCRYPT, $option);
            
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->Username, $hashedPass])) {
                return $this->gm->responsePayload($data->Username, 'success', 'Account created succesfully.', 201);
            } else {
                return $this->gm->responsePayload(null, 'failed', 'Account creation unsuccessful.', 500);
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function adminLogin($data){
        $sql = "SELECT * FROM adminauth WHERE Username=?";
        return $this->login($sql, $data, 'admin');
    }

    public function memLogin($data){
        $sql = "SELECT * FROM main WHERE Username=?";
        return $this->login($sql, $data, 'member');
    } 

    public function coachLogin($data){
        $sql = 'SELECT * FROM coachauth WHERE Username=?';
        return $this->login($sql, $data, 'coach');
    }

    public function login($sql, $data, $userType) {
        try {
            $stmt = $this->pdo->prepare($sql);
            
            if (isset($data->Username)) { // Check if the property exists
                $stmt->execute([$data->Username]); // Use the correct property
                if ($stmt->rowCount() > 0) {
                    $res = $stmt->fetchAll()[0];
                    $stmt->closeCursor();
                    if (password_verify($data->Password, $res['Password'])) {
                        $token = $this->tokenGen(['user_type' => $userType, 'User_ID' => $res['User_ID']]);
                        return $this->gm->responsePayload(array("token" => $token, "user_type" => $userType), "success", "Logged in", 200);
                    } else {
                        return $this->gm->responsePayload(null, "failed", "Username and password do not match", 400);
                    }
                } else {
                    return $this->gm->responsePayload(null, "failed", "Account doesn't exist", 404);
                }
            } else {
                return $this->gm->responsePayload(null, "failed", "Username not provided", 400);
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    

    public function logout(){
        //Logout functionality
    }

    public function tokenGen($tokenData = null)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['token_data' => $tokenData, 'exp' => date("Y-m-d", strtotime('+7 days'))]);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, SECRET_KEY, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        return array("token" => $jwt);
    }

    public function tokenPayload($payload, $is_valid = false){
        return array(
            "payload"=>$payload,
            "is_valid"=>$is_valid
        );
    }

public function verifyToken($requiredUserType = null)
{
    $jwt = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);
    
    if ($jwt[0] != 'Bearer') {
        return $this->tokenPayload(null, false);
    } else {
        // Decode the token payload
        $decoded = explode(".", $jwt[1]);
        $payload = json_decode(base64_decode($decoded[1]));
        
        // Verify the token signature
        $signature = hash_hmac('sha256', $decoded[0] . "." . $decoded[1], SECRET_KEY, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        if ($base64UrlSignature === $decoded[2]) {
            // Token is valid, check if user type matches (if provided)
            if ($requiredUserType) {
                if (isset($payload->token_data->user_type) && $payload->token_data->user_type === $requiredUserType) {
                    return $this->tokenPayload($payload, true); // Valid token and correct user type
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'Access denied. User type mismatch.', 403);
                }
            }
            // No user type check required, return valid payload
            return $this->tokenPayload($payload, true);
        } else {
            return $this->tokenPayload(null, false); // Invalid token signature
        }
    }
}


}