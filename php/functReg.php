<?php
require './db.php';
session_start();

$_SESSION['email'] = $mysqli->escape_string($_POST['email']);
$_SESSION['pwd'] = $mysqli->escape_string(password_hash($_POST['pwd'], PASSWORD_BCRYPT));
$pwd = $_SESSION['pwd'];
$email = $_SESSION['email'];
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );

// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());
// We know user email exists if the rows returned are more than 0

if ( $result->num_rows > 0 ) {
    echo 'User with this email already exists!';
}
else { // Email doesn't already exist in a database, proceed...
    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO users (email, password, hash) VALUES ('$email','$pwd', '$hash')";
    // Add user to the database
    if ($mysqli->query($sql)){
        
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
        $user = $result->fetch_assoc();

        $_SESSION['id'] = $user['id'];
        $id = $_SESSION['id'];
        $tableName = "$id"."listNames";

        $sql =  "CREATE TABLE $tableName (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            listName VARCHAR(3000) NOT NULL
        )";

        if ($mysqli->query($sql)) {
            echo 'profile';
        }

    }
    else {
        echo 'Registration failed!';
    }
}
?>
