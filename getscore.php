<?php
require_once "./config.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$stmt = $conn->prepare("SELECT * from Score ORDER BY score DESC");
$stmt->execute();
$dataR = [];

while ($data = $stmt->fetch()) {
    $dataR[]=$data;
  }
echo json_encode($dataR);
?>