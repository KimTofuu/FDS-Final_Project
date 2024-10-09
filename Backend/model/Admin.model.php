<?php
require_once($apiPath . '/interfaces/Admin.php');

class adminControls implements adminInterface {
    protected $pdo, $gm;

    public function __construct(\PDO $pdo, ResponseMethodsProj $gm) {
        $this->pdo = $pdo;
        $this->gm = $gm;
    }

    public function subscription($data){
        if(strtolower($data) === 'vip'){
            return 1;
        }
        else if(strtolower($data) === 'non-vip'){
            return 0;
        }
    }

    public function createAcc($data) {
        $sqlUser = 'INSERT INTO main(Email, Username, Password, Status) VALUES(?, ?, ?, DEFAULT)';
        $sqlSubStatus = 'INSERT INTO subscriptionstatus(User_ID, SubscriptionStat) VALUES(?, ?)';
        $sqlMemberInfo = 'INSERT INTO member_info(user_id) VALUES(?)';
    
        $option = ["cost" => 11];
        $hashedPass = password_hash($data->Password, PASSWORD_BCRYPT, $option);
    
        if (empty($data->Email) || empty($data->Username) || empty($data->Password) || empty($data->SubscriptionStat)) {
            return $this->gm->responsePayload(null, 'failed', 'Fill up all required fields.', 400);
        }
    
        try {
            $this->pdo->beginTransaction();
    
            $stmtUser = $this->pdo->prepare($sqlUser);
            if ($stmtUser->execute([$data->Email, $data->Username, $hashedPass])) {

                $lastID = $this->pdo->lastInsertId();
                $subStat = $this->subscription($data->SubscriptionStat);

                $stmtSubStatus = $this->pdo->prepare($sqlSubStatus);
                $stmtMemberInfo = $this->pdo->prepare($sqlMemberInfo);

                if ($stmtSubStatus->execute([$lastID, $subStat]) && $stmtMemberInfo->execute([$lastID])) {
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
        $sql = 'INSERT INTO coach(coachName, coachEmail, coachNum, coachPass) VALUES(?, ?, ?, ?)';

        $option = ["cost" => 11];
        $hashedPass = password_hash($data->coachPass, PASSWORD_BCRYPT, $option);
    
        if (empty($data->coachName) || empty($data->coachEmail) || empty($data->coachNum) || empty($data->coachPass)) {
            return $this->gm->responsePayload(null, 'failed', 'Fill up all required fields.', 400);
        }

        try {
            $stmt = $this->pdo->prepare($sql);

            if($stmt->execute([$data->coachName, $data->coachEmail, $data->coachNum, $hashedPass])) {
                return $this->gm->responsePayload($data->coachName, 'success', 'Account created.', 200);
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
        $sql = "SELECT m.Email, m.Username, m.Status, s.SubscriptionStat 
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
