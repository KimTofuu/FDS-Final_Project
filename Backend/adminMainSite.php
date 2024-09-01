<?php

//create members
function create(){
    $sqlCommand = "INSERT INTO AdminMain(Email, Username, Password, Status) VALUES (?, ?, ?, TRUE);";
    require_once "Services\mysql_connect_service.php";

    if ($statement = $connect->prepare($sqlComm)){
        $statement->bind_param("sss", $Email, $Username, $Password);
        $statement->execute();
    }
    $connect->close();
}

//retrieve members
function retrieveAll(){
    require_once "Services\mysql_connect_service.php";
    
    $sqlCommand = "SELECT * FROM AdminMain WHERE Status = TRUE;";

    if ($statement = $connect->prepare($sqlComm)){
        $statement->execute();
    }
    $connect->close();
}

function retrieveOne(){
    require_once "Services\mysql_connect_service.php";
    
    $sqlCommand = "SELECT * FROM AdminMain WHERE username = ? && Status = TRUE;";

    if ($statement = $connect->prepare($sqlComm)){
        $statement->bind_param("s", $Username);
        $statement->execute();
    }
    $connect->close();
}
//update members
function update(){
    require_once "Services\mysql_connect_service.php";
    
    $sqlCommand = ""; //update sql command or change status

    if ($statement = $connect->prepare($sqlComm)){
        $statement->bind_param("", $placeholder);
        $statement->execute();
    }
    $connect->close();
}

//archive members
function archive(){
    require_once "Services\mysql_connect_service.php";
    
    $sqlCommand = "UPDATE AdminMain SET Status = FALSE WHERE Username = ?;";

    if ($statement = $connect->prepare($sqlComm)){
        $statement->bind_param("s", $Username);
        $statement->execute();
    }
    $connect->close();
}