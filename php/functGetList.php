<?php
require './db.php';
session_start();

$listName = $_POST['listName'];
$terms = array();
$defs = array();

$result = $mysqli->query("SELECT * FROM $listName");

while($row = $result->fetch_assoc()) {
    $terms[] = $row['Hanzi'];
    $defs[] = $row['Def'];
}

$finalArray = Array();
$finalArray[] = $terms;
$finalArray[] = $defs;

$output = json_encode($finalArray);

echo $output;
?>