<?php
//create members
function create(){
    $sqlCommand = "INSERT INTO AdminMain(Email, Username, Password, Status) VALUES (?, ?, ?, TRUE);";
    require_once "..\Services\mysql_connect_service.php";

    if ($statement = $connect->prepare($sqlCommand)){
        $statement->bind_param("sss", $Email, $Username, $Password);
        $statement->execute();
    }
    $connect->close();
}

//retrieve members
function retrieveAll(){
    require_once "..\Services\mysql_connect_service.php";
    
    $sqlCommand = "SELECT * FROM AdminMain WHERE Status = TRUE;";

    if ($statement = $connect->prepare($sqlCommand)){
        $statement->execute();

        //for showing lang muna to
        while ($row = $result->fetch_assoc()) {
            echo "Email: " . $row["Email"] . " Username: " . $row["Username"] . "<br>";
        }
    }

    $connect->close();
}

function retrieveOne($Username){
    require_once "..\Services\mysql_connect_service.php";
    
    $sqlCommand = "SELECT * FROM AdminMain WHERE username = ? && Status = TRUE;";

    if ($statement = $connect->prepare($sqlCommand)){
        $statement->bind_param("s", $Username);
        $statement->execute();
        $result = $statement->get_result();

        //for showing lang muna to
        if ($row = $result->fetch_assoc()) {
            echo "Email: " . $row["Email"] . " Username: " . $row["Username"] . "<br>";
        } else {
            echo $Username . "is none existent";
        }
    }

    $connect->close();
}
//update members
function update(){
    require_once "..\Services\mysql_connect_service.php";
    
    $sqlCommand = ""; //update sql command or change status

    if ($statement = $connect->prepare($sqlCommand)){
        $statement->bind_param("", $placeholder);
        $statement->execute();
    }
    $connect->close();
}

//archive members
function archive(){
    require_once "..\Services\mysql_connect_service.php";
    
    $sqlCommand = "UPDATE AdminMain SET Status = FALSE WHERE Username = ?;";

    if ($statement = $connect->prepare($sqlCommand)){
        $statement->bind_param("s", $Username);
        $statement->execute();
    }
    $connect->close();
}

//server connection to create members
if ($_SERVER["REQUEST_METHOD" == 'POST']){
    require_once "..\Services\mysql_connect_service.php";
    create();
}

if ($_SERVER["REQUEST_METHOD" == 'GET']){
    require_once "..\Services\mysql_connect_service.php";
    if (isset($_GET['Username'])){
        $Username = $_GET['Username'];
        retrieveOne($Username);
    }
}

if ($_SERVER["REQUEST_METHOD" == 'PUT']){
    require_once "..\Services\mysql_connect_service.php";
    archive();
}

if ($_SERVER["REQUEST_METHOD" == 'DEL']){
    
}