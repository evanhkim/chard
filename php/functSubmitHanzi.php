<?php
require './db.php';
session_start();

$img = $_POST['imageData'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
$fileName = 'character.png';
file_put_contents($fileName, $fileData);

$output = json_encode(base64_decode (shell_exec("../py/rec.py")));
echo $output;
?> 