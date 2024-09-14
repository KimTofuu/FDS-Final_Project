<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olypus Gym Club</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
require_once "../Services/mysql_connect_service.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)){ 
        echo("All fields are required"); 
    }
    else {
        $sqlComm = "SELECT Password FROM `main` WHERE Username = ?  &&  Status = 1;";
            
            if ($statement = $connect->prepare($sqlComm)){
                $statement->bind_param("s", $username);
                $statement->execute();
                $statement->store_result();

                if($statement->num_rows>0){
                    $statement->bind_result($hashed_password);
                    $statement->fetch();

                    if(password_verify($password, $hashed_password)){
                        echo "Access Granted! Welcome!";
                    }else{
                        echo "Invalid Username or Password. Please try again.";
                        }
                }
                else {
                    echo "Invalid Username or Password. Please try again.";
                }
                $statement->close();
            }
            $connect->close();
        } 
    }
?>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter Username or Email">
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"` placeholder="Eight or more characters">
        
        <button type="submit" name="login">Log in</button>
</form>
</body>
</html>
