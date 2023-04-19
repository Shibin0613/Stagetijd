<?php
session_start();
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
