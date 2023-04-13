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
$table = "users"; //Welke table je insert
$data = [
    'naam' => "Timhamer", //de key is de column en de value is de value van die column
    'email' => "tfhammersma@gmail.com", //de key is de column en de value is de value van die column
    'role' => 1, //de key is de column en de value is de value van die column
];
$result1 = DB::select($table, $data);
var_dump($result1);

$userid = 2;
$active = 1;
$result2 = DB::update("UPDATE `users` SET `active` = :active WHERE id = :userid", ['active' => $active, 'userid' => $userid]);

$data1 = [ //Multiple rows die je toevoegt
    [ //Elke array is een row
        'naam' => 'Tim', //de key is de column en de value is de value van die column
        'email' => 'tfhammersma@gmail.com', //de key is de column en de value is de value van die column
        'role' => 1, //de key is de column en de value is de value van die column
        'active' => 1, //de key is de column en de value is de value van die column
    ],
    [ //Elke array is een row
        'naam' => 'Tim2', //de key is de column en de value is de value van die column
        'email' => 'tfhammersma@gmail.com', //de key is de column en de value is de value van die column
        'role' => 1, //de key is de column en de value is de value van die column
        'active' => 1, //de key is de column en de value is de value van die column
    ]
];

$data2 = [ //Een single row die je toevoegt
    'naam' => 'Tim', //de key is de column en de value is de value van die column
    'email' => 'tfhammersma@gmail.com', //de key is de column en de value is de value van die column
    'role' => 1, //de key is de column en de value is de value van die column
    'active' => 1, //de key is de column en de value is de value van die column
];
$table = "users"; //Welke table je insert
$result3 = DB::insert($table, $data);

$mainTables = [
    [
        "taken", //Eerste table waar je een andere tabel aan toevoegt met een inner join
        "koppeltakentags" //Tweede table waar je een andere table aan deze en de tabel hier boven toevoegt.
    ],
    [
        "id", //Dit is de column van de eerste table waar je een inner join op uitvoert    taken.id
        "tagId" //Dit is de column van de tweede table waar je een inner join op uitvoert    koppeltakentags.tagId
    ]
];
$koppelTables = [
    [
        "koppeltakentags", //De table die je aan de eerste main table toevoegt
        "tags" //De table die je aan de tweede main table toevoegt
    ],
    [
        ['takenId', '*'], //De eerste parameter is welke column je van de eerste koppeltable die je koppelt met de eerste main table. De tweede parameter is vervolgens wat je wil selecteren
        ['id', '*'] //De eerste parameter is welke column je van de tweede koppeltable die je koppelt met de tweede main table. De tweede parameter is vervolgens wat je wil selecteren
    ]
];
$whereClauseMainTable = [
    [
        "taken.id", //de column waar je op filtert in de eerste main table
        2
    ] //de value van de eerste column waar je op filtert
];

$result4 = DB::join($mainTables[0], $mainTables[1], $koppelTables[0], $koppelTables[1], $whereClauseMainTable[0]);
