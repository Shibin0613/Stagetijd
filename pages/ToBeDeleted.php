<?php
include('../functions/services.php');
include "header.php";

$studentService = new StudentServices();
$logService = new LogService();

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
// var_dump($user->internship[0]->logboek[0]->tuesday->task);
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
    <?= $user->name ?>
    <br>
    <?= $internship->company ?>
    <table>
    <tr>
        <th>Weeknummer</th>
        <th>Maandag</th>
        <th>Dinsdag</th>
        <th>Woensdag</th>
        <th>Donderdag</th>
        <th>Vrijdag</th>
        <th>Goedkeuren</th>
    </tr>
    <tr>
        <th><?= $log->weekNumber ?></th>
        <th><?php $logService->DayLoop($monday) ?></th>
        <th><?php $logService->DayLoop($tuesday) ?></th>
        <th><?php $logService->DayLoop($wednesday) ?></th>
        <th><?php $logService->DayLoop($thursday) ?></th>
        <th><?php $logService->DayLoop($friday) ?></th>
        <th>Nee</th>
    </tr>
    </table>
    <br>
    
  
   
    
    
</body>

</html>