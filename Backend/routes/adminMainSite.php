<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method='POST'>
        <!-- testing create-->
         Email: <input type="text" name="email">
         Username: <input type="text" name="username">
         Password: <input type="password" name="password">
         <button type="submit">Create Account</button>
    </form>

    <form method='GET'>
        <!-- retrieve account/s -->
        Username: <input type="text" name="username">
        <button type="submit">Search Account</button>
    </form>

    <form method='POST' id="archiveUser">
        <!-- update user status test -->
         Username: <input type="text" name="username">
         <input type="hidden" name="action" value="update_status">
         <button type="submit">Change Account Status</button>

    </form>
</body>
</html>
<?php

//create members
function create(){
    $Email = $_POST['email'];
    $Username =  $_POST['username'];
    $Password = $_POST['password'];
    $hashedPass = password_hash($Password, PASSWORD_BCRYPT);

    if (!isset($_POST['email'], $_POST['username'], $_POST['password'])){
        echo "Please fill in all fields";
        return;
    }
    require_once "..\Services\mysql_connect_service.php";

    if(!$connect){
        echo "Connection Failed";
        return;
    }

    $sqlCommand= "INSERT INTO `main`(`Email`, `Username`, `Password`, `Status`) VALUES (?, ?, ?, DEFAULT);";

    if ($statement = $connect->prepare($sqlCommand)){
        $statement->bind_param('sss', $Email, $Username, $hashedPass);
        $statement->execute();
        echo 'Account successfully created!';
    }
    else{
        echo 'Command Error' . $connect->error;
    }

    $connect->close();
}

function retrieveAll(){
    require_once "..\Services\mysql_connect_service.php";
    
    $sqlCommand = "SELECT * FROM main WHERE Status = 1;";

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
    
    $sqlCommand = "SELECT * FROM main WHERE username = ? && Status = 1;";

    if ($statement = $connect->prepare($sqlCommand)){
        $statement->bind_param("s", $Username);
        $statement->execute();
        $result = $statement->get_result();

        //for showing lang muna to
        if ($row = $result->fetch_assoc()) {
            $accountStatus = ($row["Status"] == 1) ? "Active" : "Inactive";
            echo "Email: " . $row["Email"] . "<br>" . " Username: " . $row["Username"] . "<br>" . "Status:" . $accountStatus . "<br>";
        } else {
            echo $Username . " is none existent";
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
function archive($Username){
    require_once "..\Services\mysql_connect_service.php";
    
    $sqlCommand = "UPDATE main SET Status = 0 WHERE Username = ?;";

    if ($statement = $connect->prepare($sqlCommand)){
        $statement->bind_param("s", $Username);
        $statement->execute();
        echo 'Status changed, account now archived';
    }
    $connect->close();
}

//server connection to create members
if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    if (isset($_POST['action']) && $_POST['action'] == 'update_status') {
        // Handle the update status request
        if (isset($_POST['username'])) {
            $Username = $_POST['username'];
            archive($Username);
        } else {
            echo 'Username parameter missing';
        }
    } else {
        // Handle other POST requests (e.g., create)
        create();
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'GET'){
    if (isset($_GET['username'])){
        $Username = $_GET['username'];
        retrieveOne($Username);
    }
}

// if ($_SERVER["REQUEST_METHOD"] == 'GET'){
//     require_once "..\Services\mysql_connect_service.php";
//     retrieveAll();
// }

if ($_SERVER["REQUEST_METHOD"] == 'DEL'){
    
}
?>