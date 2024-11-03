<?php
require_once($apiPath . '/interfaces/Admin.php');

class adminControls implements adminInterface {
    protected $pdo, $gm;

    public function __construct(\PDO $pdo, ResponseMethodsProj $gm) {
        $this->pdo = $pdo;
        $this->gm = $gm;
    }

    public function subscription($data){
        if(strtolower($data) === 'paid'){
            return 1;
        }else if(strtolower($data) === 'unpaid'){
            return 0;
        }else{
            return null;
        }
    }

    public function subPlan($data) {
        $result = [
            'plan' => NULL,
            'duration' => NULL
        ];
    
        // Determine plan and duration based on input data
        switch (strtolower($data)) {
            case 'basic plan':
                $result['plan'] = 'Basic Plan';
                $result['duration'] = '+ 14 days';
                break;
            case 'advanced plan':
                $result['plan'] = 'Advanced Plan';
                $result['duration'] = '+ 30 days';
                break;
            case 'master plan':
                $result['plan'] = 'Master Plan';
                $result['duration'] = '+ 60 days';
                break;
            default:
                $result = NULL;
                break;
        }
    
        return $result;
    }
    
    public function setMemSubPlan($data){
        $subPlanDetails = $this->subPlan($data);
    
        $sql = "UPDATE membership_duration SET subPlan = :subPlan, duration = :duration";
    
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':subPlan', $subPlanDetails['plan']);
            $stmt->bindParam(':duration', $subPlanDetails['duration']);
    
            if($stmt->execute()){
                return $this->gm->responsePayload(get_object_vars($data), 'success', 'Data updated', 200);
            } else {
                return $this->gm->responsePayload(null, 'failed', 'Update failed', 403);
            }
        } catch(PDOException $e){
            $this->pdo->rollBack();
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
    
    public function createAcc($data) {
        $sqlUser = 'INSERT INTO main(Email, Username, Password, ArchiveStatus) VALUES(?, ?, ?, DEFAULT)';
        $sqlSubStatus = 'INSERT INTO membership_duration(User_ID, SubscriptionStat, subPlan, duration, startingDate, expiryDate) VALUES(?, ?, ?, ?, ?, ?)';
        $sqlMemberInfo = 'INSERT INTO member_info(user_id) VALUES(?)';
        $sqlCheckUser = 'SELECT COUNT(*) FROM main WHERE LOWER(Username) = LOWER(?)';
    
        $option = ["cost" => 11];
        $hashedPass = password_hash($data->Password, PASSWORD_BCRYPT, $option);
    
        if (empty($data->Email) || empty($data->Username) || empty($data->Password) || empty($data->SubscriptionStat)) {
            return $this->gm->responsePayload(null, 'failed', 'Fill up all required fields.', 400);
        }
    
        try {
            $stmtCheckUser = $this->pdo->prepare($sqlCheckUser);
            $stmtCheckUser->execute([$data->Username]);
            $userExists = $stmtCheckUser->fetchColumn();
    
            if ($userExists > 0) {
                return $this->gm->responsePayload(null, 'failed', 'Username already exists.', 409);
            }
    
            $this->pdo->beginTransaction();
    
            $stmtUser = $this->pdo->prepare($sqlUser);
            if ($stmtUser->execute([$data->Email, $data->Username, $hashedPass])) {
    
                $lastID = $this->pdo->lastInsertId();
                $subStat = $this->subscription($data->SubscriptionStat);
    
                // Get plan and duration using subPlan
                $subPlanDetails = $this->subPlan($data->subPlan);
                $subPlan = $subPlanDetails['plan'];
                $memDur = $subPlanDetails['duration'];
    
                // Calculate dates
                $startingDate = date('Y-m-d');
                $expiryDate = date('Y-m-d', strtotime($startingDate . $memDur));
    
                // Prepare statements for each insert
                $stmtSubStatus = $this->pdo->prepare($sqlSubStatus);
                $stmtMemberInfo = $this->pdo->prepare($sqlMemberInfo);
    
                if ($stmtSubStatus->execute([$lastID, $subStat, $subPlan, $memDur, $startingDate, $expiryDate]) &&
                    $stmtMemberInfo->execute([$lastID])) {
    
                    $this->pdo->commit();
                    return $this->gm->responsePayload($this->getOneAcc((object)['User_ID' => $lastID]), 'success', 'Account created successfully.', 201);
                } else {
                    $this->pdo->rollBack();
                    return $this->gm->responsePayload(null, 'failed', 'Subscription status insert failed.', 500);
                }
    
            } else {
                $this->pdo->rollBack();
                return $this->gm->responsePayload(null, 'failed', 'Account creation unsuccessful.', 500);
            }
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
    

    public function coachCreate($data){
        $sqlCheckUser = 'SELECT COUNT(*) FROM coach WHERE LOWER(coachName) = LOWER(?)';
        $sqlCoachInfo = 'INSERT INTO coach_info(Coach_ID) VALUES(?)';
        $sql = 'INSERT INTO coach(coachName, coachEmail, coachPass) VALUES(?, ?, ?)';

        $option = ["cost" => 11];
        $hashedPass = password_hash($data->coachPass, PASSWORD_BCRYPT, $option);
    
        if (empty($data->coachName) || empty($data->coachEmail) || empty($data->coachPass)) {
            return $this->gm->responsePayload(null, 'failed', 'Fill up all required fields.', 400);
        }

        try {
            $stmtCheckUser = $this->pdo->prepare($sqlCheckUser);
            $stmtCheckUser->execute([$data->coachName]);
            $userExists = $stmtCheckUser->fetchColumn();

            if ($userExists > 0) {return $this->gm->responsePayload(null, 'failed', 'Username already exists.', 409);}
            
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute([$data->coachName, $data->coachEmail, $hashedPass])) {
                
                $lastID = $this->pdo->lastInsertId();
                $stmtCoachInfo = $this->pdo->prepare($sqlCoachInfo);

                if($stmtCoachInfo->execute([$lastID])){
                    $this->pdo->commit();
                    return $this->gm->responsePayload(array("Name" => $data->coachName, "Email" => $data->coachEmail), 'success', 'Account created.', 200);
                }else{
                    $this->pdo->rollBack();
                    return $this->gm->responsePayload(null, 'failed', 'Account creation failed', 403);
                }
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Account creation failed', 403);
            }
        }catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }    
    

    public function getAllAcc() {
        $sql = "SELECT Email, Username, Status FROM main";
        $data = array(); 
        
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0){
                    foreach($stmt->fetchAll() as $d){
                        array_push($data, $d);
                    }
                    return $this->gm->responsePayload($data, 'success', 'Data retrieved successfully.', 200);
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'No data present.', 404);
                }
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function getOneAcc($data) {
        $sql = "SELECT m.Email, m.Username, m.ArchiveStatus, s.SubscriptionStat, s.subPlan
            FROM main m
            LEFT JOIN membership_duration s ON m.User_ID = s.User_ID
            WHERE m.User_ID = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->User_ID])) {
                $data = $stmt->fetchAll();
                if ($stmt->rowCount() > 0) {
                    return $this->gm->responsePayload($data, 'success', 'User retrieved successfully.', 200);
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'User does not exist.', 404);
                }
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function archStat($data) {
        $sql = "UPDATE main SET Status = CASE WHEN Status = 0 then 1 WHEN Status = 1 then 0 END WHERE User_ID = ?";

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->User_ID])) {
                if ($stmt->rowCount() > 0) {
                    return $this->gm->responsePayload($this->getOneAcc((object)['User_ID' => $data->User_ID]), 'success', 'Data successfully updated.', 200);
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'User does not exist.', 404);
                }
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function delAcc($data) {
        $sql = "DELETE FROM main WHERE User_ID = ?";

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->User_ID])) {
                if ($stmt->rowCount() > 0) {
                    return $this->gm->responsePayload(null, 'success', 'User successfully deleted.', 200);
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'User doesn\'t exist or is already deleted.', 404);
                }
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function changePaymentStatus(){
        $sql = 'UPDATE membership_duration
                SET SubscriptionStat = 0
                WHERE expiryDate = CURDATE()';

        try{
            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute()){
                return $this->gm->responsePayload(null, 'success', "Accounts' status updated.", 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Accounts status update failed.', 404);
                
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);

        }
    }
}
