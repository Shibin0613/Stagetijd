<?php
//Incluse the required files
include('../functions/services.php');
include "header.php";

//Makes it able to use the functions inside the services
$studentService = new StudentServices();
$logService = new LogService();

//Get user info, internship info, log info, task info, tag info and comments that are connected to the user.
$user = $studentService->getUserBy(['id' => 36,]);

//Defines which log needs to be shown depending on the internship
$internshipFilter = 0;

//Gets the internship object from the filter.
$internship = $user->internship[$internshipFilter];
?>
<!DOCTYPE html>
<html lang="en">
<? if (isset($_GET['id'])) : ?>
    
<? endif ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logboek</title>
</head>

<body>
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
        <?php foreach ($internship->logboek as $key => $value) : ?>
            <tr>
                <td><?= $value->weekNumber ?></td>
                <td><a href="ToBeDeleted.php?id=<?= $value->monday->id ?>">Maandag</td>
                <td><a href="ToBeDeleted.php?id=<?= $value->tuesday->id ?>">Dinsdag</td>
                <td><a href="ToBeDeleted.php?id=<?= $value->wednesday->id ?>">wednesday</td>
                <td><a href="ToBeDeleted.php?id=<?= $value->thursday->id ?>">thursday</td>
                <td><a href="ToBeDeleted.php?id=<?= $value->friday->id ?>">friday</td>
                <?php switch ($value->approved) {
                    case 0:
                        echo "<td> Niet goedgekeurd</td>";
                        break;
                    case 1:
                        echo "<td> Goedgekeurd</td>";
                        break;
                    default:
                        echo "<td> Er is iets mis gegaan.</td>";
                        break;
                }?>
            </tr>
        <?php endforeach ?>
    </table>
</body>
</html>