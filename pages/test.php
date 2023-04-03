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
$naam = "Tim";
$email = "tfh@gmail.com";
$rol = 1;
$result1 = DB::insert("INSERT INTO `users` (`naam`, `email`, `role`) VALUES (:naam, :email, :rol)", ['naam' => $naam, 'email' => $email, 'rol' => $rol, ]);
$userid = 2;
$active = 1;
$result2 = DB::update("UPDATE `users` SET `active` = :active WHERE id = :userid", ['active' => $active, 'userid' => $userid]);
$result3 = DB::select("SELECT * FROM users WHERE id = :userid", ['userid' => $userid]);
var_dump($result3);

