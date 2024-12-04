<?php
require_once($apiPath . '/interfaces/Admin.php');

class adminControls implements adminInterface {
    protected $pdo, $gm, $mw;

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
        $sqlUser = 'INSERT INTO member(Email, Username, Password, ArchiveStatus) VALUES(?, ?, ?, DEFAULT)';
        $sqlSubStatus = 'INSERT INTO membership_duration(User_ID, SubscriptionStat, subPlan, duration, startingDate, expiryDate) VALUES(?, ?, ?, ?, ?, ?)';
        $sqlCheckUser = 'SELECT COUNT(*) FROM member WHERE LOWER(Username) = LOWER(?) AND LOWER(Email) = LOWER(?)';
        $sqlMemberInfo = 'INSERT INTO member_info(user_id, name, conNum, eConNum, address, age, sex, gender, bodyType, activityLevel, weight, height, BMI) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    
        $option = ["cost" => 11];
        $hashedPass = password_hash($data->Password, PASSWORD_BCRYPT, $option);
    
        if (empty($data->Email) || empty($data->Username) || empty($data->Password) || empty($data->SubscriptionStat)) {
            return $this->gm->responsePayload(null, 'failed', 'Fill up all required fields.', 400);
        }
    
        try {
            $stmtCheckUser = $this->pdo->prepare($sqlCheckUser);
            $stmtCheckUser->execute([$data->Username, $data->Email]);
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

                $validBodyTypes = ['ectomorph', 'mesomorph', 'endomorph'];
                $validActivityLevels = ['sedentary', 'lightly active', 'moderately active', 'very active', 'extra active'];

                // Check if body type and activity level are valid
                if (!in_array($data->bodyType, $validBodyTypes)) {
                    return $this->gm->responsePayload(null, 'failed', 'Invalid body type. Please choose from: ' . implode(', ', $validBodyTypes), 400);
                }

                if (!in_array(strtolower($data->activityLevel), $validActivityLevels)) {
                    return $this->gm->responsePayload(null, 'failed', 'Invalid activity level. Please choose from: ' . implode(', ', $validActivityLevels), 400);
                }
    
                if ($stmtSubStatus->execute([$lastID, $subStat, $subPlan, $memDur, $startingDate, $expiryDate]) &&
                    $stmtMemberInfo->execute([$lastID, $data->name, $data->conNum, $data->eConNum, $data->address, $data->age, $this->SexIdentifier($data->sex), $data->gender, $data->bodyType, $data->activityLevel, $data->weight, $data->height, $this->bmi((int)$data->weight, (int)$data->height)])) {
                    
                    // Add the new code blocks here // basta may aayusin dito <<3
                    if (isset($data->condition_ids) && is_array($data->condition_ids) && count($data->condition_ids) > 0) {
                        $conditionIds = $data->condition_ids;
                        $sqlUserMedCon = 'INSERT INTO user_conditions(user_id, condition_id) VALUES(?, ?)';
                        $stmtUserMedCon = $this->pdo->prepare($sqlUserMedCon);
                        foreach ($conditionIds as $conditionId) {
                            $stmtUserMedCon->execute([$lastID, $conditionId]);
                        }
                    } else {
                        $sqlUserMedCon = 'INSERT INTO user_conditions(user_id, condition_id) VALUES(?, 0)';
                        $stmtUserMedCon = $this->pdo->prepare($sqlUserMedCon);
                        $stmtUserMedCon->execute([$lastID]);
                    }

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
        $sqlCheckUser = 'SELECT COUNT(*) FROM coach WHERE LOWER(Username) = LOWER(?)';
        $sqlCoachInfo = 'INSERT INTO coach_info(Coach_ID) VALUES(?)';
        $sql = 'INSERT INTO coach(Username, coachEmail, Password) VALUES(?, ?, ?)';

        $option = ["cost" => 11];
        $hashedPass = password_hash($data->Password, PASSWORD_BCRYPT, $option);
    
        if (empty($data->Username) || empty($data->coachEmail) || empty($data->Password)) {
            return $this->gm->responsePayload(null, 'failed', 'Fill up all required fields.', 400);
        }

        try {
            $stmtCheckUser = $this->pdo->prepare($sqlCheckUser);
            $stmtCheckUser->execute([$data->Username]);
            $userExists = $stmtCheckUser->fetchColumn();

            if ($userExists > 0) {return $this->gm->responsePayload(null, 'failed', 'Username already exists.', 409);}
            
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute([$data->Username, $data->coachEmail, $hashedPass])) {
                
                $lastID = $this->pdo->lastInsertId();
                $stmtCoachInfo = $this->pdo->prepare($sqlCoachInfo);

                if($stmtCoachInfo->execute([$lastID])){
                    $this->pdo->commit();
                    return $this->gm->responsePayload(array("Name" => $data->Username, "Email" => $data->coachEmail), 'success', 'Account created.', 200);
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
        $sql = "SELECT m.User_ID, m.Email, m.Username, m.ArchiveStatus, s.SubscriptionStat, s.subPlan, 
            mi.name, mi.conNum, mi.eConNum, mi.address, mi.age, mi.sex, mi.gender, mi.bodyType, 
            mi.activityLevel, mi.weight, mi.height, mi.BMI, s.startingDate, s.expiryDate, s.duration,
            GROUP_CONCAT(mc.medCondi_Name) AS conditions
            FROM member m
            LEFT JOIN membership_duration s ON m.User_ID = s.User_ID
            LEFT JOIN member_info mi ON m.User_ID = mi.User_ID
            LEFT JOIN user_conditions uc ON m.User_ID = uc.user_id
            LEFT JOIN medcondi mc ON uc.condition_id = mc.medCondi_ID
            WHERE m.ArchiveStatus = 1
            GROUP BY m.User_ID";

        $data = []; 
        
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0){
                    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $d){

                        $d['conditions'] = $d['conditions'] ? explode(',', $d['conditions']) : [];
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
            FROM member m
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
        $sql = "UPDATE member SET Status = CASE WHEN Status = 0 then 1 WHEN Status = 1 then 0 END WHERE User_ID = ?";

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
        $sql = "DELETE FROM member WHERE User_ID = ?";

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
    public function setPaid($data){
        $sql = "UPDATE membership_duration SET SubscriptionStat = 1 WHERE User_ID = ?";

        try{
     $stmt = $this->pdo->prepare($sql);
            if($stmt->execute([$data->User_ID])){
                return $this->gm->responsePayload(null, 'success', "Accounts' status updated.", 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Accounts status update failed.', 404);
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
}
