<?php
require './db.php';
session_start();

$listName = $_POST['listName'];
$id = $_SESSION['id'];
$tableListNames = "$id"."listNames";

$sql = "DELETE FROM $tableListNames WHERE listName = '$listName'";
$result = $mysqli->query($sql);

$sql = "DROP TABLE $listName";
$result = $mysqli->query($sql);

?>