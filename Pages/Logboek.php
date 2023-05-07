<!--
Save this file as calendar.html

Save all three files (calendar.html, calendar.css and calendar.js)in the same folder
Open the html file with a web browser
-->

<?php

//Include the required files
include('../functions/services.php');

//Makes it able to use the functions inside the services
$studentService = new StudentServices();
$logService = new LogService();

//Get user info, internship info, log info, task info, tag info and comments that are connected to the user.
if (isset($_GET['Userid']) && $_SESSION['role'] === 1) {
  $_SESSION['logUserId'] = $_GET["Userid"];
} elseif (!isset($_GET['Userid']) && $_SESSION['role'] === 2) {
  $_SESSION['logUserId'] = $_SESSION["userId"];
} elseif (!isset($_GET['Userid']) && $_SESSION['role'] === 3 && !isset($_SESSION['logUserId'])) {
  $firstInternshipUser = $logService->getFirstUserFromSupervisor($_SESSION['userId']);
  $_SESSION['logUserId'] = $firstInternshipUser;
}
$user = $studentService->getUserBy(['id' => $_SESSION['logUserId']]);

//Defines which log needs to be shown depending on the internship
$internshipFilter = 0;

//Gets the internship object from the filter.
$internship = $user->internship[$internshipFilter];

use Controllers\DB;

// $tagHours = $logService->getTagHours($internship);
// var_dump($tagHours);

$logService->createLogboekWeek($internship);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Calendar</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=yes" />
  <link rel="stylesheet" type="text/css" href="calendar.css">
  <script type="text/javascript" src="calendar.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Work', 11],
        ['Eat', 2],
        ['Commute', 2],
        ['Watch TV', 2],
        ['Sleep', 7]
      ]);

      var options = {
        title: 'My Daily Activities'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);


    }
  </script>
  <script>
    const today = new Date();
    const dateInput = document.getElementById("myDateInput");
    dateInput.value = today.toISOString().substr(0, 10);

    function checkdelete() {
      return confirm('Weet je zeker dat je deze daily willen verwijderen?');
    }
    var weeknummer = "<?php echo $weeknummer; ?>";
    document.getElementById("weeknummer").innerHTML = weeknummer;
  </script>
</head>

<body>
  <div class="parent">
    <div class="grid1">
      <?php if (isset($_GET["id"])) :
        //shows the user's tasks from given day
        $logService->ReturnTasksByDayId($internship, intval($_GET["id"]), $_SESSION['role']);

        //if the user is a student, show the button "taak toevoegen"
        if ($_SESSION['role'] === 2) : ?>
          <button type="button" data-toggle="modal" data-target="#myModal">Taak toevoegen</button>
          <br><br>
          <b><?php $logService->ReturnCommentByDayId(); ?></b>
        <?php endif; ?>


        <?php //if the user is a supervisor or a teacher, show the button "Opmerking toevoegen"
        if (($_SESSION['role'] === 1) || ($_SESSION['role'] === 3)) {
          echo "<button type='button' data-toggle='modal' data-target='#myModal1'>Opmerking toevoegen</button>";
          ?><br><br><b><?php $logService->ReturnCommentByDayId(); ?></b><?php
        }
        ?>
      <?php endif; ?>
      <h1>logboek</h1>
      <table>
        <thead>
          <tr>
            <th>Weeknummer</th>
            <th>Maandag</th>
            <th>Dinsdag</th>
            <th>Woensdag</th>
            <th>Donderdag</th>
            <th>Vrijdag</th>
            <th>Uren</th>
            <th>Goedkeuren</th>
          </tr>
        </thead>
        <?php foreach ($internship->logboek as $key => $value) : ?>
          <tr>
            <td><?= $value->weekNumber ?></td>
            <td><a href="logboek.php?id=<?= $value->monday->id ?>">Maandag</td>
            <td><a href="logboek.php?id=<?= $value->tuesday->id ?>">Dinsdag</td>
            <td><a href="logboek.php?id=<?= $value->wednesday->id ?>">Woensdag</td>
            <td><a href="logboek.php?id=<?= $value->thursday->id ?>">Donderdag</td>
            <td><a href="logboek.php?id=<?= $value->friday->id ?>">Vrijdag</td>
            <td>Uren</td>

            <?php
            if ($_SESSION['role'] === 2 || $_SESSION['role'] === 1) :
            switch ($value->approved) {
              case 0:
                echo "<td> Niet goedgekeurd</td>";
                break;
              case 1:
                echo "<td> Goedgekeurd</td>";
                break;
              default:
                echo "<td> Er is iets mis gegaan.</td>";
                break;
            } 
            elseif ($_SESSION['role']) : 
              //week goedkeuren voor de praktijkbegelijder
            ?>
          </tr>
        <?php endif; endforeach; ?>
      </table>

    </div>
    <div class="grid2">
      <h1>bedrijfs info</h1>
      <?php
      echo $internship->company;
      echo "<br>"; ?>


      <h1>statistiek</h1>
      <?php $totalHours = $logService->ReturnTotalWorkHours($internship);

      ?>
      <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar bg-success" style="width: <?php echo $percentageHours = $totalHours / 8; ?>%"></div><center><?php echo $totalHours . "/800"; ?>%</center>
      </div>
      <div id="piechart" style="width: 400px; height: 300px;"></div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="emapleModalLabel">Taak toevoegen</h4>
          <button type='submit' name='ziek'>Ziek</button>
          <button type='submit' name='vrij'>Vrij</button>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <form method='POST' action=''>
            <br>
            <p>Taak</p>
            <textarea rows='4' cols='50' name='taken'></textarea>
            <br>
            <p>Hoelang ben je daarmee bezig geweest?<br>
            </p>
            <input type='number' name='uren' required max='8'> uren
            <br>
            <p>Tags</p>
            <select name='tags'>
              <?php $logService->getTagsInAddTask(); ?>
            </select>
            <button type="submit"><a href="TagsOverzicht.php">Tags</a></button>
            <br>
            <br>
            <button type='submit' name='inleveren'>Inleveren</button>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal2 -->
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="emapleModalLabel">Opmerking toevoegen</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <?php $logService->ReturnTasksByDayId($internship, intval($_GET["id"]), $_SESSION['role']); ?>
          <form method='POST' action=''>
            <br>
            <?php $werkdagid = $_GET['id'];
            ?>
            <p>Opmerking</p>
            <textarea rows='4' cols='50' name='opmerking'></textarea>
            <br>
            <br>
            <br>
            <button type='submit' name='opmerkingopslaan'>Opslaan</button>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>


<?php
if (isset($_POST['inleveren'])) {

  $insertedTasks = $logService->insertTask();

  //voegtoe in tabel taken 

  //als het gelukt is, alert taak is toegevoegd
  if ($insertedTasks) :
    echo "<script>alert('Taak is toegevoegd')</script>"; ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">
  <?php else :
    echo "<script>alert('Het is niet gelukt om een taak toe te voegen, probeer later opnieuw!')</script>"; ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">
<?php endif;
  //haal vanuit de database taken id waar je net de taak hebt toegevoegd. 
  $takentable = "taken"; //Welke table je insert
  $takendata = [];
  $result = DB::select($takentable, $takendata);
  $laatstetaakid = end($result)['id'];
  $logService->addTagtoTask($laatstetaakid);
  $logService->addTasktoWorkday($laatstetaakid);
}
?>

<?php
if (isset($_POST['opmerkingopslaan'])) {

  $insertedCommend = $logService->insertComment();

  //voegtoe in tabel taken 

  //als het gelukt is, alert taak is toegevoegd
  if ($insertedCommend) :
    echo "<script>alert('Opmerking is toegevoegd')</script>"; ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">
  <?php else :
    echo "<script>alert('Het is niet gelukt om een opmerking toe te voegen, probeer later opnieuw!')</script>"; ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">
<?php endif;
  //haal vanuit de database taken id waar je net de taak hebt toegevoegd. 
  $opmerkingtable = "opmerkingen"; //Welke table je insert
  $opmerkingdata = [];
  $result = DB::select($opmerkingtable, $opmerkingdata);
  $laatsteopmerkingid = end($result)['id'];
  $logService->addCommenttoWorkday($laatsteopmerkingid);
}
?>