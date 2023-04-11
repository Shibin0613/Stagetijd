<?php
include('../functions/services.php');
include "header.php";

$studentService = new StudentServices();

$user = $studentService->getUserBy(['id' => 36,]);
echo $user->name;
echo $user->internship[0]->company;