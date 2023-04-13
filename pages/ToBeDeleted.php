<?php
include('../functions/services.php');
include "header.php";

$studentService = new StudentServices();

$user = $studentService->getUserBy(['id' => 36,]);

$internshipFilter = 0;
$weeknumber = 0;

$internship = $user->internship[$internshipFilter];
$log = $internship->logboek[$weeknumber];
$monday = $log->monday;
$tuesday = $log->tuesday;
$wednesday = $log->wednesday;
$thursday = $log->thursday;
$friday = $log->friday;
echo $user->internship[0]->logboek[0]->tuesday->tasks[0]->tags[1]->name;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logboek</title>
</head>
<body>
    
</body>
</html>