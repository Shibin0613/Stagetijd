<?php

// DB Conn
// $servername = "localhost";
// $username = "";
// $password = "";
// $db = "";

$servername = "localhost";
$username = "root";
$password = "";
$db = "stagetijd";

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    echo "Connection Failed";
}
?>