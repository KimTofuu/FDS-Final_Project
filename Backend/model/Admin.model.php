<?php
require_once($apiPath . '/interfaces/Admin.php');

class adminControls implements adminInterface {
    protected $pdo, $gm;

    public function __construct(\PDO $pdo, ResponseMethodsProj $gm) {
        $this->pdo = $pdo;
        $this->gm = $gm;
    }

    public function createAcc($data){
        $sql = 'INSERT INTO main(Email, Username, Password, Status) VALUES(?, ?, ?, ?)';
        
        $option = [
            "cost" => 11 
        ];
        $hashedPass = password_hash($data->Password, PASSWORD_BCRYPT, $option);

        if (!isset($data->Email) || !isset($data->Username) || !isset($data->Password)) {
            return $this->gm->responsePayload(null, 'failed', 'Fill up all required fields.', 400);
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->Email, $data->Username, $hashedPass, $data->Status])) {
                $lastID = $this->pdo->lastInsertId();
                return $this->gm->responsePayload($this->getOneAcc((object)['User_ID' => $lastID]), 'success', 'Account created succesfully.', 201);
            } else {
                return $this->gm->responsePayload(null, 'failed', 'Account creation unsuccessful.', 500);
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function getAllAcc() {
        $sql = "SELECT Email, Username, Status FROM main";
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
        $sql = "SELECT Email, Username, Status FROM main WHERE User_ID = ?";
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
