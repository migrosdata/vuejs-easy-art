<?php
    define('DB_SERVER', 'jc6ky.myd.infomaniak.com');
    define('DB_USERNAME', 'jc6ky_easyart');
    define('DB_PASSWORD', 'QBR_6ul0mQ5');
    define('DB_NAME', 'jc6ky_easyart');
    $servername = "jc6ky.myd.infomaniak.com";
    $username = "jc6ky_easyart";
    $password = "QBR_6ul0mQ5";
    $dbname = "jc6ky_easyart";
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


