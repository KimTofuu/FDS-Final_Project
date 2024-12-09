<?php
require_once($apiPath . '/interfaces/Coach.php');
class coach implements coachInterface{
    protected $pdo, $gm, $mailer;
    

    public function __construct(\PDO $pdo, ResponseMethodsProj $gm, Mailer $mailer){
        $this->pdo = $pdo;
        $this->gm = $gm;
        $this->mailer = $mailer;
    }
    public function SexIdentifier($data) {
        if(strtolower($data) === 'male'){
            return 1;
        }
        return 0;
    }
    public function seeMemDet($data){
        if (!isset($data->Username)) {
            // Handle the case where $data does not have the Username property
            return $this->gm->responsePayload(null, 'error', 'Invalid request data', 400);
        }
        $coachID = $this->gm->getIDFromTokenBackend();
        $getClient = 'SELECT m.User_ID, m.Email, m.Username, n.name, n.conNum, 
            n.age, n.sex, n.bodyType, n.activityLevel, n.weight, n.height, 
            n.BMI 
            FROM member m
            JOIN coach_classes cc ON m.User_ID = cc.user_id
            JOIN member_info n ON m.User_ID = n.user_id
            WHERE cc.coach_id = ? AND m.Username = ?';
    
        try{
            $getClient = $this->pdo->prepare($getClient);
            $getClient->execute([$coachID, $data->Username]); 
            $data = $getClient->fetchAll(PDO::FETCH_ASSOC);
            if (isset($data)){
                return $this->gm->responsePayload($data, 'success', 'Client details retrieved successfully', 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Client not found', 403);
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    } 

    public function sendMessage($data){
        $coachID = $this->gm->getIDFromTokenBackend();
        $coachEmail = 'SELECT CoachEmail FROM coach WHERE User_ID = ?';
        $userDetails = 'SELECT Email, User_ID FROM member WHERE Username = LOWER(?)';
        $checkClient = 'SELECT COUNT(*) FROM coach_classes WHERE user_id = ? AND coach_id = ?';

        try{
            $getCoachEmail = $this->pdo->prepare($coachEmail);

            if($getCoachEmail->execute([$coachID])){
                $getCoachEmail = $getCoachEmail->fetchColumn();
                $userDetails = $this->pdo->prepare($userDetails);
                
                if($userDetails->execute([$data->Username])){
                    $userDetails = $userDetails->fetchAll();
                    
                    $checkClient = $this->pdo->prepare($checkClient);
                    $checkClient->execute([$userDetails[0]['User_ID'], $coachID]);
                    if($checkClient->rowCount() == 0){
                        return $this->gm->responsePayload(null, 'failed', 'User is not a client', 403);
                    }

                    $message = $data->Message;
                    $htmlBody = '<p>' . $message . '</p>';
                    $this->mailer->coachSendMail($data->Subject, $htmlBody, $message, $userDetails[0]['Email'], $data->Username);
                    return $this->gm->responsePayload(null, 'success', 'Message sent successfully', 200);
                }
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function getAllClients(){
        $coachID = $this->gm->getIDFromTokenBackend();
        $getClients = 'SELECT m.Username, n.name
            FROM member m
            JOIN coach_classes cc ON m.User_ID = cc.user_id
            JOIN member_info n ON m.User_ID = n.user_id
            WHERE cc.coach_id = ?';
    
        try{
            $gerClients = $this->pdo->prepare($getClients);
            $gerClients->execute([$coachID]); 
            $data = $gerClients->fetchAll();
            if (!empty($data)){
                return $this->gm->responsePayload($data, 'success', 'Clients retrieved successfully', 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'No clients found', 403);
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
    public function updateInfo($data){
        $coachID = $this->gm->getIDFromTokenBackend();

        $sql = 'UPDATE coach_info SET Name = ?, Age = ?, Sex = ?, Gender = ?, Height = ?, Weight = ?, ContactNo = ?, Address = ?  WHERE Coach_ID = ?';

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->Name, $data->Age, $this->SexIdentifier($data->Sex), $data->Gender, $data->Weight, $data->Height, $data->ContactNo, $data->Address, $coachID])) {
                return $this->gm->responsePayload($data, 'success', 'Data uploaded', 200);
            } else {
                return $this->gm->responsePayload(null, 'failed', 'Upload failed', 403);
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
    public function viewInfo(){
        $coachID = $this->gm->getIDFromTokenBackend();
        $sql = 'SELECT c.Username, ci.Name, ci.Age, ci.Sex, ci.Gender, ci.Height, ci.Weight, ci.ContactNo, ci.Address
                FROM coach c
                LEFT JOIN coach_info ci ON c.User_ID = ci.Coach_ID 
                WHERE Coach_ID = ?';
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$coachID])) {
                $data = $stmt->fetchAll(PDO ::FETCH_ASSOC);
                return $this->gm->responsePayload($data, 'success', 'Data uploaded', 200);
            } else {
                return $this->gm->responsePayload(null, 'failed', 'Upload failed', 403);
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
}