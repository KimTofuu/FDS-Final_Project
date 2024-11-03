<?php

require_once($apiPath . '/interfaces/Responses.php');

class ResponseMethodsProj implements ResponseInterfacePHPTemp
{
    public function responsePayload($payload, $remarks, $message, $code){
        $status = array("remarks" => $remarks, "message" => $message);
        http_response_code($code);
        return array("status" => $status, "payload" => $payload, "timestamp" => date('Y-m-d H:i:s'), "prepared_by" => "Olympus Dev. Team");
    }

    public function notFound(){
        echo json_encode([
            "msg"=>"Your endpoint does not exist"
        ]);
        http_response_code(403);
    }

    public function getIDFromToken(){
        if (isset($_COOKIE['Authorization'])) {
            $jwt = explode(' ', $_COOKIE['Authorization']);
            
            if ($jwt[0] === 'Bearer' && isset($jwt[1])) {
                $token = $jwt[1];
                
                $decoded = explode(".", $token);
                
                $payload = json_decode(base64_decode($decoded[1]));
                
                $signature = hash_hmac('sha256', $decoded[0] . "." . $decoded[1], $_ENV['SECRET_KEY'], true);
                $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
                
                if ($base64UrlSignature === $decoded[2]) {
                    if (isset($payload->token_data->User_ID)) {
                        return $payload->token_data->User_ID;
                    }
                }
            }
        }
    }
}