<?php
require './db.php';
session_start();

$email = $_SESSION['email'];
$id = $_SESSION['id'];

$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

$user = $result->fetch_assoc();

$array = Array();
$array[] = $email;
$array[] = $id;

$tableListNames = $id."listNames";
$listNames = Array();

$result = $mysqli->query("SELECT * FROM $tableListNames");

while($row = $result->fetch_assoc()) {
	$listNames[] = $row['listName'];
}

/*
$charsArray = Array();
$defsArray = Array();
$scoresArray = Array();
$imgsArray = Array();

$charsArray[] = $row['Characters'];
$defsArray[] = $row['Definition'];
$scoresArray[] = $row['Score'];
$imgsArray[] = $row['Image'];
*/

$finalArray = Array();
$finalArray[] = $array;
$finalArray[] = $listNames;
/*
$finalArray[] = $charsArray;
$finalArray[] = $defsArray;
$finalArray[] = $scoresArray;
$finalArray[] = $imgsArray;
*/
$output = json_encode($finalArray);

echo $output;
?>
