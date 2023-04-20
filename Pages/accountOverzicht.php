<?php 
require_once('../functions/services.php');

use Controllers\DB;
$AccountOverviewService = new AccountOverviewServices();
?>
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
    $users = $AccountOverviewService->filter();
    ?>
    <form method="POST" action="">
        <select name="active_filter" id="active_filter">
            <option value="1">Actief</option>
            <option value="0">Niet Actief</option>
        </select>
        <select name="role_filter" id="role_filter">
            <option value="1">Docenten</option>
            <option value="2">Studenten</option>
            <option value="3">Praktijkbegeleider</option>
        </select>
        <input type="submit" value="Filter">
    </form>
    <div class="container">
        <div class="row">
        </div class="col-sm">

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                
                <?php

                if ($users && $_SESSION['roleUserFilter'] == 2) : ?>
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>E-mail</th>
                        <th>verwijderen</th>
                    </tr>
                </thead>

                <?php    foreach ($users as $row) {
                        echo '
                <tr>
                <a href="logboek.php?Userid=' . $row['id'] . '"><div class="StudentenOverzicht">' . $row['naam'] . '</div></a>
                </tr>';
                    }
                elseif ($users && $_SESSION['roleUserFilter'] == 1) : ?>
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>E-mail</th>
                        <th>verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $row) :
                            $id = $row['id'];
                            echo '
                            <tr>
                            <td>' . $row['naam'] . '<input type="hidden" name="id[]" value="' . $row['id'] . '"></td>
                            <td>' . $row['email'] . '</td>
                            <td><a href="?userId=' . $id . '"><i class="fa-solid fa-trash"></i></a></td>
                            </tr>
                            ';
                        endforeach;
                        elseif ($users && $_SESSION['roleUserFilter'] == 3) : ?>
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>E-mail</th>
                                <th>Actief</th>
                            </tr>
                        </thead>
                    <tbody>
                        <?php foreach ($users as $row) :
                            $id = $row['id'];
                            echo '
                            <tr>
                                    <td>' . $row['naam'] . '<input type="hidden" name="id[]" value="' . $row['id'] . '"></td>
                                    <td>' . $row['email'] . '</td>
                                    <td><a href="?userId=' . $id . '"><i class="fa-solid fa-trash"></i></a></td>
                                </tr>
                            ';
                        endforeach;
                    else :
                        echo "No users found.";
                    endif;

                    ?>


        </div>
    </div>
    </div>