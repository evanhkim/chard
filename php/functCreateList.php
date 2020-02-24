<?php
require './db.php';
session_start();

$listName = $_POST['listName'];

$id= $_SESSION['id'];

$listTableName = "$id"."_"."$listName";
$listName = "$id"."listNames";

if ($result = $mysqli->query("SHOW TABLES LIKE '".$listTableName."'")) {
    if($result->num_rows == 1) {
        echo "repeat";
    }
    else {
        $sql =  "CREATE TABLE $listTableName (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                Hanzi VARCHAR(30) NOT NULL,
                Def VARCHAR(30) NOT NULL,
                Score VARCHAR(6),
                Img VARCHAR(10000)
            )";

        if ($mysqli->query($sql)){
            
            $sql = "INSERT INTO $listName (listName) VALUES ('$listTableName')";
            
            $mysqli->query($sql);
            
            echo 'yes';
        }
        else {
            echo 'no';
        }
    }
}