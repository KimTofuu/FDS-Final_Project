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

        $sql = "SELECT * FROM member WHERE Username=?";
        return $this->login($sql, $data, 'member');
    } 

    public function coachLogin($data){

        $sql = 'SELECT * FROM coach WHERE Username=?';
        return $this->login($sql, $data, 'coach');
    }

    public function login($sql, $data, $userType) {
        try {
            $stmt = $this->pdo->prepare($sql);
            
            if (isset($data->Username)) { 
                $stmt->execute([$data->Username]); 
                if ($stmt->rowCount() > 0) {
                    $res = $stmt->fetchAll()[0];
                    $stmt->closeCursor();
                    if (password_verify($data->Password, $res['Password'])) {
                        $token = $this->tokenGen(['user_type' => $userType, 'User_ID' => $res['User_ID']]);
                        setcookie('Authorization','Bearer ' . $token['token'], time() + (86400 * 7), '/', '', false, false);
                        // $redirectUrl = $url . $res['User_ID'];
                        // header('Location: $apipath');
                        return $this->gm->responsePayload(array("token" => $token['token'], "user_type" => $userType, "User_ID" => $res['User_ID']), "success", "Logged in", 200);
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

    public function logout() {
        $token = $_COOKIE['Authorization'];

        if (!$token) {
            return $this->gm->responsePayload(null, "failed", "No token found for logout.", 400);
        }

        $blacklistResult = $this->handleBlacklist($token);
        setcookie('Authorization', '', time() - 3600, '/', '', true, true);

        if ($blacklistResult['status'] === "success") {
            return $this->gm->responsePayload(null, "success", "Logged out successfully and token blacklisted", 200);
        } else {
            return $blacklistResult;
        }
    }

    public function handleBlacklist($token) {
    if ($this->checkBlacklistStatus($token)) {
        return $this->gm->responsePayload(null, "failed", "Token already blacklisted", 400);
    }

    return $this->setBlacklistStatus($token);
}


    public function checkBlacklistStatus($token) {
        $checkBLstat = 'SELECT COUNT(*) AS nums FROM blacklist WHERE token = ?';
        try {
            $checkStat = $this->pdo->prepare($checkBLstat);
            $checkStat->execute([$token]);
            $res = $checkStat->fetchColumn();
            return $res > 0; 
        } catch (PDOException $e) {
            error_log("Error checking blacklist status: " . $e->getMessage());
            return $this->gm->responsePayload(null, "error", "An internal error occurred.", 500);
        }
    }


    public function setBlacklistStatus($token) {
        $setBLstat = 'INSERT INTO blacklist(token) VALUES (?) ON DUPLICATE KEY UPDATE token = VALUES(token)';
        try {
            $setStat = $this->pdo->prepare($setBLstat);
            $setStat->execute([$token]);
            return $this->gm->responsePayload(null, "success", "Token has been added to blacklist", 200);
        } catch (PDOException $e) {
            error_log("Error setting blacklist status: " . $e->getMessage());
            return $this->gm->responsePayload(null, "error", "An internal error occurred.", 500);
        }
    }


    public function tokenGen($tokenData = null)
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['token_data' => $tokenData, 'exp' => date("Y-m-d", strtotime('+7 days')), 'jti' => bin2hex(random_bytes(16))]);
        
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $_ENV['SECRET_KEY'],true);
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

    public function verifyToken($token = null, $requiredUserType = null) {
        //$authHeader = $_COOKIE['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? null;

        $authHeader = $token->Token;


        if (!$authHeader || strpos($authHeader, 'Bearer ') !== 0) {
            return $this->tokenPayload(null, false);
        }

        $token = substr($authHeader, 7); // Strip "Bearer " prefix
        if ($this->checkBlacklistStatus($token)) {
            return $this->tokenPayload(null, false);
        }

        $decoded = explode(".", $token);
        if (count($decoded) !== 3) {
            return $this->tokenPayload(null, false);
        }

        $payload = json_decode(base64_decode($decoded[1]));
        if (!$payload) {
            return $this->tokenPayload(null, true);
        }

        if (isset($payload->exp) && time() > $payload->exp) {
            return $this->tokenPayload(null, false);
        }

        $signature = hash_hmac('sha256', $decoded[0] . "." . $decoded[1], $_ENV['SECRET_KEY'], true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        if ($base64UrlSignature !== $decoded[2]) {
            return $this->tokenPayload(null, false);
        }

        if ($requiredUserType && isset($payload->token_data->user_type) && $payload->token_data->user_type !== $requiredUserType) {
            return $this->tokenPayload(null, false);
        }

        if (!isset($payload->token_data->User_ID)) {
            return $this->tokenPayload(null, false);
        }

        return $this->tokenPayload($payload, true);
    }

}