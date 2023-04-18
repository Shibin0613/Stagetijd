<?php
//Include the required files
include('../functions/services.php');

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



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logboek</title>
</head>
<?php if (isset($_GET["id"])) :
    #$logService->ReturnTasksByDayId($internship, intval($_GET["id"]));
    echo $internship->company;
    echo "<br>";
    $totalHours = $logService->ReturnTotalWorkHours($internship);
    echo $totalHours."/800";
endif; ?>

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
                <td><a href="ToBeDeleted.php?id=<?= $value->wednesday->id ?>">Woensdag</td>
                <td><a href="ToBeDeleted.php?id=<?= $value->thursday->id ?>">Donderdag</td>
                <td><a href="ToBeDeleted.php?id=<?= $value->friday->id ?>">Vrijdag</td>
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
                } ?>
            </tr>
        <?php endforeach ?>
    </table>
</body>

</html>