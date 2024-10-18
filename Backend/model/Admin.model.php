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
        }
        return 0;
    }

    public function subPlan($data){
        if(strtolower($data) === 'basic plan'){
            return 'Basic Plan';
        }
        if(strtolower($data) === 'advance plan'){
            return 'Advanced Plan';
        }
        if(strtolower($data) === 'master plan'){
            return 'Master Plan';
        }
        return NULL;
    }

    public function setMemSubPlan($data){
        $subPlan = $this->subPlan($data);

        $sql = "UPDATE subscriptionstatus SET subPlan = $subPlan";

        try{
            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute()){
                return $this->gm->responsePayload(get_object_vars($data), 'success', 'Data updated', 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Update failed', 403);
            }
        }catch(PDOException $e){
            $this->pdo->rollBack();
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function createAcc($data) {
        $sqlUser = 'INSERT INTO main(Email, Username, Password, ArchiveStatus) VALUES(?, ?, ?, DEFAULT)';
        $sqlSubStatus = 'INSERT INTO subscriptionstatus(User_ID, SubscriptionStat, subPlan) VALUES(?, ?, ?)';
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

            if ($userExists > 0) {return $this->gm->responsePayload(null, 'failed', 'Username already exists.', 409);}
            
            $this->pdo->beginTransaction();
    
            $stmtUser = $this->pdo->prepare($sqlUser);
            if ($stmtUser->execute([$data->Email, $data->Username, $hashedPass])) {

                $lastID = $this->pdo->lastInsertId();
                $subStat = $this->subscription($data->SubscriptionStat);
                $subPlan = $this->subPlan($data->subPlan);

                $stmtSubStatus = $this->pdo->prepare($sqlSubStatus);
                $stmtMemberInfo = $this->pdo->prepare($sqlMemberInfo);

                if ($stmtSubStatus->execute([$lastID, $subStat, $subPlan]) && $stmtMemberInfo->execute([$lastID])) {
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
    
        if (empty($data->coachName) || empty($data->coachEmail) || empty($data->coachNum) || empty($data->coachPass)) {
            return $this->gm->responsePayload(null, 'failed', 'Fill up all required fields.', 400);
        }

        try {
            $stmtCheckUser = $this->pdo->prepare($sqlCheckUser);
            $stmtCheckUser->execute([$data->Username]);
            $userExists = $stmtCheckUser->fetchColumn();

            if ($userExists > 0) {return $this->gm->responsePayload(null, 'failed', 'Username already exists.', 409);}
            
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare($sql);
            if($stmt->execute([$data->coachName, $data->coachEmail, $data->coachNum, $hashedPass])) {
                $lastID = $this->pdo->lastInsertId();

                $stmtCoachInfo = $this->pdo->prepare($sqlCoachInfo);
                
                if($stmtCoachInfo->execute([$lastID])){
                    $this->pdo->commit();
                    return $this->gm->responsePayload(array("Name" => $data->coachName, "Email" => $data->coachEmail, "Contact Number" => $data->coachNum), 'success', 'Account created.', 200);
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
        $sql = "SELECT Email, Username,  Status FROM main";
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute()) {
                $data = $stmt->fetchAll();
                if ($stmt->rowCount() > 0) {
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
        $sql = "SELECT m.Email, m.Username, m.ArchiveStatus, s.SubscriptionStat 
            FROM main m
            LEFT JOIN subscriptionstatus s ON m.User_ID = s.User_ID
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
}
