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

    public function getIDFromToken(){ // WILL RETRIEVE DATA FROM COOKIE
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

    }public function getUserTypeFromToken(){ // WILL RETRIEVE DATA FROM COOKIE
        if (isset($_COOKIE['Authorization'])) {
            $jwt = explode(' ', $_COOKIE['Authorization']);
            
            if ($jwt[0] === 'Bearer' && isset($jwt[1])) {
                $token = $jwt[1];
                
                $decoded = explode(".", $token);
                
                $payload = json_decode(base64_decode($decoded[1]));
                
                $signature = hash_hmac('sha256', $decoded[0] . "." . $decoded[1], $_ENV['SECRET_KEY'], true);
                $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
                
                if ($base64UrlSignature === $decoded[2]) {
                    if (isset($payload->token_data->user_type)) {
                        return $payload->token_data->user_type;
                    }
                }
            }
        }
    }

    function errorhandling($data) {
        if (json_last_error() !== JSON_ERROR_NONE) {
            $error_code = json_last_error();
            $error_message = json_last_error_msg();
    
            $error_details = [
                JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded.',
                JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON.',
                JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded.',
                JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON.',
                JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded.',
                JSON_ERROR_RECURSION => 'One or more recursive references in the value to be encoded.',
                JSON_ERROR_INF_OR_NAN => 'One or more NAN or INF values in the value to be encoded.',
                JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given.',
                JSON_ERROR_INVALID_PROPERTY_NAME => 'A property name that cannot be encoded was given.',
                JSON_ERROR_UTF16 => 'Malformed UTF-16 characters, possibly incorrectly encoded.'
            ];
    
            echo json_encode([
                'status' => 'error',
                'error_code' => $error_code,
                'message' => $error_message,
                'details' => isset($error_details[$error_code]) ? $error_details[$error_code] : 'Unknown error'
            ]);
            return;
        }
    
        if (empty($data)) {
            echo json_encode(['status' => 'error', 'message' => 'No data received.']);
            return;
        }
    }
}