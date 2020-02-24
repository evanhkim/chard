<?php
require './db.php';
session_start();

$terms = $_POST['terms'];
$defs = $_POST['defs'];
$listName = $_POST['listName'];

$sql = "TRUNCATE TABLE $listName";
$result = $mysqli->query($sql);

for ($index=0; $index<count($terms); $index++) {
   
    if (strlen(trim($terms[$index])) != 0) {
        $sql = "INSERT INTO $listName (Hanzi, Def, Score) VALUES ( '$terms[$index]','$defs[$index]', 0)";
        $result = $mysqli->query($sql);
    }
}

