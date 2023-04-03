<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php
include("header.php");

use Controllers\DB;

$result = DB::select("SELECT * FROM users WHERE id = :driehoek", ['driehoek' => 1]);
var_dump($result);

$users = DB::select("SELECT * FROM users");
var_dump($users);

