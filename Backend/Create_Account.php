#scrap all

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympus Gym Club</title>
</head>

    <form method="post">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" >

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" >
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Eight or more characters">
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" >

        <button type="submit" name="login">Log in</button> 
    </form>

<?php
require_once "Services\mysql_connect_service.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) die("All fields are ");

    if ($password != $confirmPassword) die("Password doesn't match");

    $securedPass = password_hash($password, PASSWORD_DEFAULT);

    $statement = $connect->prepare("INSERT INTO authentication (User_ID, User_Email, Username, Password) VALUES (NULL, ?, ?, ?)");
    $statement->bind_param("sss", $email, $username, $securedPass);

    if ($statement->execute()) {
        echo "Sign up successful!";
    } else {
        echo "Error: " . $statement->error;
    }

    $statement->close();
    $connect->close();
}
?>
</body>
</html>