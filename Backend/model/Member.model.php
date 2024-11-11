<?php
require_once($apiPath . "/interfaces/Member.php");

class member implements memberInterface {
    protected $pdo, $gm;

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

    private function getAgeRange($age) {
        if ($age >= 18 && $age <= 30) {
            return '18-30';
        } elseif ($age >= 31 && $age <= 45) {
            return '31-45';
        } elseif ($age >= 46 && $age <= 60) {
            return '46-60';
        } else {
            return '60+';
        }
    }

    public function editInfo($data) {
        $userID = $this->gm->getIDFromToken();

        if ($data->height == 0) {
            return $this->gm->responsePayload(null, 'failed', 'Height cannot be zero', 403);
        }

        $bmi = $this->bmi((int)$data->weight, (int)$data->height);

        $sql = 'UPDATE member_info SET name = ?, conNum = ?, eConNum = ?, address = ?, age = ?, sex = ?, gender = ?, weight = ?, height = ?, BMI = ? WHERE user_id = ?';

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$data->name, $data->conNum, $data->eConNum, $data->address, $data->age, $this->SexIdentifier($data->sex), $data->gender, $data->weight, $data->height, $bmi, $userID])) {
                return $this->gm->responsePayload(get_object_vars($data), 'success', 'Data uploaded', 200);
            } else {
                return $this->gm->responsePayload(null, 'failed', 'Upload failed', 403);
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    
    public function viewInfo() {
        $userID = $this->gm->getIDFromToken();
        if (!$userID) {
            return $this->gm->responsePayload(null, 'error', 'Invalid user ID', 400);
        }

        $sql = "SELECT * FROM member_info WHERE user_id = ?";
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$userID])) {
                $data = $stmt->fetchAll();
                if ($stmt->rowCount() > 0) {
                    return $this->gm->responsePayload($data, 'success', 'User data retrieved successfully.', 200);
                } else {
                    return $this->gm->responsePayload(null, 'failed', 'User data does not exist.', 404);
                }
            }
        } catch (PDOException $e) {
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function setAlarm($data){
        $userID = $this->gm->getIDFromToken();

        $sql = 'INSERT INTO gymalarm(User_ID, day, time) VALUES(?, ?, ?)';
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$userID, $data->day, $data->time])) {
                return $this->gm->responsePayload($data, 'success', 'Alarm or reminder set', 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Alarm or reminder not set', 403);
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function setSession($data){
        $userID = $this->gm->getIDFromToken();

        $sql = 'INSERT INTO gymsession(User_ID, date, time, Coach_ID) VALUES(?, ?, ?, ?)';
        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$userID, $data->date, $data->time, $data->Coach_ID])) {
                return $this->gm->responsePayload($data, 'success', 'Alarm or reminder set', 200);
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Alarm or reminder not set', 403);
            }
        }catch(PDOException $e){
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }

    public function calcBodCalcNeed($data){
        $userID = $this->gm->getIDFromToken();
        $getSex = 'SELECT sex FROM member_info WHERE user_id = ?';
        $getWeight = 'SELECT weight FROM member_info WHERE user_id = ?';
        $getHeight = 'SELECT height FROM member_info WHERE user_id = ?';
        $age = 'SELECT age FROM member_info WHERE user_id = ?';
        $getActLvl = 'SELECT activityLevel FROM member_info WHERE user_id = ?';
    
        try {
            $this->pdo->beginTransaction();
    
            $stmt1 = $this->pdo->prepare($getSex);
            $stmt2 = $this->pdo->prepare($getWeight);
            $stmt3 = $this->pdo->prepare($getHeight);
            $stmt4 = $this->pdo->prepare($age);
            $stmt5 = $this->pdo->prepare($getActLvl);
    
            if($stmt1->execute([$userID]) && $stmt2->execute([$userID]) && $stmt3->execute([$userID]) && $stmt4->execute([$userID]) && $stmt5->execute([$userID])){
                $this->pdo->commit();
    
                $sex = $stmt1->fetchColumn();
                $weight = $stmt2->fetchColumn();
                $height = $stmt3->fetchColumn();
                $age = $stmt4->fetchColumn();
                $activityLevel = $stmt5->fetchColumn();
    
                if($sex == 1){
                    $baseMetabolicRate = 66 + (6.2 * $weight) + (13.7 * $height) - (6.8 * $age);
                }else if($sex == 0){
                    $baseMetabolicRate = 655 + (4.35 * $weight) + (4.7 * $height) - (4.7 * $age);
                }
    
                if (!isset($activityLevel)) {
                    return $this->gm->responsePayload(null, 'failed', 'Missing activity level data', 400);
                }
    
                $activityLevel = strtolower($activityLevel);
    
                if($activityLevel == 'sedentary'){$dailyCaloricNeed = $baseMetabolicRate * 1.2;}
                else if($activityLevel == 'lightly active'){$dailyCaloricNeed = $baseMetabolicRate * 1.375;}
                else if($activityLevel == 'moderately active'){$dailyCaloricNeed = $baseMetabolicRate * 1.55;}
                else if($activityLevel == 'very active'){$dailyCaloricNeed = $baseMetabolicRate * 1.725;}
                else if($activityLevel == 'extra active'){$dailyCaloricNeed = $baseMetabolicRate * 1.9;}

                if(isset($data->goal) && $data->goal == 'lose weight'){
                    $dailyCaloricNeed -= 500;
                    return $this->gm->responsePayload($dailyCaloricNeed, 'success', 'Your daily caloric need for weight loss', 200);
                }else if(isset($data->goal) && $data->goal == 'gain weight'){
                    $dailyCaloricNeed += 500;
                    return $this->gm->responsePayload($dailyCaloricNeed, 'success', 'Your daily caloric need for weight gain', 200);
                }else if(isset($dailyCaloricNeed) && empty($date->goal)){
                    return $this->gm->responsePayload($dailyCaloricNeed, 'success', 'Caloric need for maintenance', 200);
                }else{
                    return $this->gm->responsePayload(null, 'failed', 'Invalid activity level', 400);
                }
                
            }else{
                return $this->gm->responsePayload(null, 'failed', 'Caloric Needs not set', 403);
            }
        }catch(PDOException $e){
            $this->pdo->rollBack();
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }
    
    public function calcFoodCalor($data){
        if (!isset($data->food) || !isset($data->protein) || !isset($data->carbs) || !isset($data->fats)) {
            return $this->gm->responsePayload(null, 'failed', 'Missing food or nutrient data', 400);
        }
    
        $food = $data->food;
        $protein = $data->protein;
        $carbs = $data->carbs;  
        $fats = $data->fats;
    
        $calories = ($protein * 4) + ($carbs * 4) + ($fats * 9);
    
        return $this->gm->responsePayload(array('food' => $food, 'calories' => $calories), 'success', 'Food total calories', 200);
    }

    public function getRecomm($data){
        $userID = $this->gm->getIDFromToken();

        $goal = $data->goal;
        $fitnessLevel = $data->fitnessLevel;

        $validGoals = ['weight loss', 'muscle gain', 'general fitness', 'flexibility', 'endurance'];
        $validFitnessLevels = ['beginner', 'intermediate', 'advanced'];
    
        // Check if input goal and fitness level are valid
        if (!in_array(strtolower($goal), $validGoals)) {
            return $this->gm->responsePayload(null, 'error', 'Invalid goal. Please choose from: ' . implode(', ', $validGoals), 400);
        }
        if (!in_array(strtolower($fitnessLevel), $validFitnessLevels)) {
            return $this->gm->responsePayload(null, 'error', 'Invalid fitness level. Please choose from: ' . implode(', ', $validFitnessLevels), 400);
        }

        $getActLvl = 'SELECT activityLevel FROM member_info WHERE user_id = ?';
        $getBodyType = 'SELECT bodyType FROM member_info WHERE user_id = ?';
        $getAge = 'SELECT age FROM member_info WHERE user_id = ?';
        $retRecom = 'SELECT 
                        workout_plan, 
                        diet_plan, 
                        additional_notes,
                        (
                            (activity_level = ? AND activity_level IS NOT NULL) +
                            (body_type = ? AND body_type IS NOT NULL) +
                            (age_range = ? AND age_range IS NOT NULL) +
                            (goal = ? AND goal IS NOT NULL) +
                            (fitness_level = ? AND fitness_level IS NOT NULL)
                        ) AS match_score
                    FROM recommendation_dataset
                    ORDER BY match_score DESC
                    LIMIT 1;';

        try{
            $this->pdo->beginTransaction();

            $stmt1 = $this->pdo->prepare($getActLvl);
            $stmt2 = $this->pdo->prepare($getBodyType);
            $stmt3 = $this->pdo->prepare($getAge);  
            $stmt4 = $this->pdo->prepare($retRecom);

            if($stmt1->execute([$userID]) && $stmt2->execute([$userID]) && $stmt3->execute([$userID])){

                $actLvl = $stmt1->fetchColumn();
                $bodyType = $stmt2->fetchColumn();
                $age = $stmt3->fetchColumn();
                $ageRange = $this->getAgeRange($age);

                $actLvl = ucwords($actLvl);
                $bodyType = ucwords($bodyType);
                $goal = ucwords($goal);
                $fitnessLevel = ucwords($fitnessLevel);

                if($stmt4->execute([$actLvl, $bodyType, $ageRange, $goal, $fitnessLevel])){
                    $data = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                    $this->pdo->commit();
                    return $this->gm->responsePayload($data, 'success', 'Recommended workout and diet plan', 200);
                }
            }else{
                return $this->gm->responsePayload(null, 'error', 'Invalid parametera', 500);
            }
        }catch(PDOException $e){
            $this->pdo->rollBack();
            return $this->gm->responsePayload(null, 'error', $e->getMessage(), 500);
        }
    }   
}