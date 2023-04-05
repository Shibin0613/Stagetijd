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
$table = "users";
$data = [
    'naam' => "Timhamer", 
    'email' => "tfhammersma@gmail.com", 
    'role' => 1, 
];
$result1 = DB::select($table, $data);
var_dump($result1);

// $userid = 2;
// $active = 1;
// $result2 = DB::update("UPDATE `users` SET `active` = :active WHERE id = :userid", ['active' => $active, 'userid' => $userid]);

// $data = [
//     [
//         'naam' => 'Tim',
//         'email' => 'tfhammersma@gmail.com',
//         'role' => 1,
//         'active' => 1,
//     ],
//     [
//         'naam' => 'Tim2',
//         'email' => 'tfhammersma@gmail.com',
//         'role' => 1,
//         'active' => 1,
//     ]
// ];

// $data = [
//     'naam' => 'Tim',
//     'email' => 'tfhammersma@gmail.com',
//     'role' => 1,
//     'active' => 1,
// ];
// $table = "users";
// $result3 = DB::insert($table, $data);
// var_dump($result3);

