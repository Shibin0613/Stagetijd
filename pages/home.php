<?php
session_start();
if ($_SESSION['userId'] === null || $_SESSION['role'] === null){
    header("location: ../index.php");
}
switch ($_SESSION['role']) {
    case '1':
        include('accountOverzicht.php');
        break;
    case '2':
        include('Logboek.php');
        break;
    case '3':
        include('Logboek.php');
        break;
    default:
        echo "Er is iets mis gegaan.";
        break;
}
