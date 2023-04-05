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

$table = "users";
$active_filter = isset($_POST['active_filter']) ? $_POST['active_filter'] : "1";
$data = [
    'active' => $active_filter,
    'role' => 1,
];
$result = DB::select($table, $data);

?>
        <form method="POST" action="">
    <select name="active_filter" id="active_filter">
        <option value="1">Actief</option>
        <option value="0">Niet Actief</option>
    </select>
    <input type="submit" value="Filter">
</form>  
<div class="container">
    <div class="row">
        </div class="col-sm"> 


<?php 
 
            if ($result) {
            foreach($result as $row) {
            echo '<a href="docentenOverzicht.php?id=' . $row['id'] . '"><div class="StudentenOverzicht">' . $row['naam'] . '</div></a>';
        }
        } else {
            echo "No users found.";
        }
       
        ?>

        
        </div>
    </div>
</div>
