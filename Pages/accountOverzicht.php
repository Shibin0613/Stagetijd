<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/gebruikertoevoegen.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<title>StudentenOverzicht</title>
</head>
<body>
<?php
include "header.php";
use Controllers\DB;
//select alle studenten
$role = "1";
$result = DB::select("SELECT * FROM users WHERE `role` = :rol", ['rol' => $role]);




?>

<div class="container">
    <div class="row">
        </div class="col-sm"> 
        <?php
            if ($result) {
            foreach($result as $row) {
            // var_dump($row['naam']);
            echo '<a href="docentenOverzicht.php?id=' . $row['id'] . '"><div class="StudentenOverzicht">' . $row['naam'] . '</div></a>';
        }
        } else {
            echo "No users found.";
        }

        ?>
        </div>
    </div>
</div>