<?php
require_once "./config.php";

header('Access-Control-Allow-Methods: POST');
$stmt = $conn->prepare("Insert into Score(username,score,date,ip,country) VALUES (?,?,?,?,?)");

$username = $_POST["username"];
$score = $_POST["score"];
$country = $_POST["country"];
$ip = $_POST["ip"];
$now = date('j-n-Y');
$stmt->execute(array($username, $score, $now,$ip,$country));
echo "okay";
?>