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
if (isset($_GET['Userid'])&& $_SESSION['role'] === 1){
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

$weeknummer = date('W');
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
</head>

<body>
  <div class="parent">
    <div class="grid1">
      <?php if (isset($_GET["id"])) :
        $logService->ReturnTasksByDayId($internship, intval($_GET["id"]), $_SESSION['role']); ?>
        <?php if ($_SESSION['role'] === 2) : ?>
          <button type="button" data-toggle="modal" data-target="#myModal">Taak toevoegen</button>
        <?php endif; ?>
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




      <?php
      $table = "logboek";
      $data = [];
      $result = DB::select($table, $data);
      $weeknrfromdatabase = end($result)['weeknummer'];
      //Insert naar werkdagtabel in een loop met aankomende 5 dagen als het weer maandag is

      if ($weeknrfromdatabase != $weeknummer) {

        $table = "werkdag";
        $date = new DateTime();
        for ($i = 0; $i < 5; $i++) { // loop 5 times
          $data = [
            'datum' => $date->format('Y-m-d'),
            'ziek' => '0',
            'vrij' => '0',
          ];
          $date->add(new DateInterval('P1D')); // add 1 day to the date
          $werkdaginsert = DB::insert($table, $data);
        }
        //Vanuit database de werkdag uit om in koppeltabel Logboek te inserten
        $table = "werkdag";
        $data = [];
        $result = DB::select($table, $data);
        $laatstewerkdagid = end($result)['id'];
        $tweedelaatstewerkdagid = (end($result)['id']) - 1;
        $derdelaatstewerkdagid = (end($result)['id']) - 2;
        $vierdelaatstewerkdagid = (end($result)['id']) - 3;
        $vijfdelaatstewerkdagid = (end($result)['id']) - 4;


        $table = "logboek";
        $data = [
          'stageId' => $internship->id,
          'weeknummer' => $weeknummer,
          'maandagId' => $vijfdelaatstewerkdagid,
          'dinsdagId' => $vierdelaatstewerkdagid,
          'woensdagId' => $derdelaatstewerkdagid,
          'donderdagId' => $tweedelaatstewerkdagid,
          'vrijdagId' => $laatstewerkdagid,
        ];
        $result = DB::insert($table, $data);
      }


      ?>
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
        <div class="progress-bar bg-success" style="width: <?php echo $percentageHours = $totalHours / 8; ?>%"><?php echo $totalHours . "/800"; ?>%</div>
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
              <?php
              $table = "tags";
              $data = [];
              $tagsresult = DB::select($table, $data);
              foreach ($tagsresult as $result) {
                $tagid = $result['id'];
                echo
                "<option value='$tagid'>" . $result['naam'] . "</option>";
              }
              ?>
            </select>
            <button type="submit"><a href="TagsOverzicht.php">Tags</a></button>
            <p>Datum</p>
            <input type='date' name='datum' id='myDateInput' readonly>
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

</body>

</html>
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

<?php
if (isset($_POST['inleveren'])) {



  //voegtoe in tabel taken 
  $taken = $_POST['taken'];
  $uren = $_POST['uren'];

  $takentable = "taken";
  $takendata = [
    'taak' => $taken,
    'uur' => $uren,
  ];
  //als het gelukt is, alert taak is toegevoegd
  if ($taakinsert = DB::insert($takentable, $takendata)) {
    echo "<script>alert('Taak is toegevoegd')</script>";
?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">
  <?php
  } else {
    echo "<script>alert('Het is niet gelukt om een taak toe te voegen, probeer later opnieuw!')</script>";
  ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">
<?php
  }




  //haal vanuit de database taken id waar je net de taak hebt toegevoegd. 
  $takentable = "taken"; //Welke table je insert
  $takendata = [];
  $result = DB::select($takentable, $takendata);
  $laatstetaakid = end($result)['id'];


  //voegtoe naar koppeltabel takentags
  $tags = $_POST['tags'];
  $koppeltakentagstable = "koppeltakentags";
  $koppeltakentagsdata = [
    'takenId' => $laatstetaakid,
    'tagId' => $tags,
  ];
  $taakinsert = DB::insert($koppeltakentagstable, $koppeltakentagsdata);





  //voegtoe naar koppeltakenwerkdag
  $today = $_GET['id'];
  $werkdagtable = "werkdag";
  $werkdagdata = [];
  $result = DB::select($werkdagtable, $werkdagdata);
  $check = array_search($today, array_column($result, 'id'));
  $werkdagidoftoday = $result[$check]['id'];


  $koppeltakenwerkdagtable = "koppeltakenwerkdag";
  $koppeltakenwerkdagdata = [
    'taakId' => $laatstetaakid,
    'werkdagId' => $werkdagidoftoday,
  ];
  $result = DB::insert($koppeltakenwerkdagtable, $koppeltakenwerkdagdata);
}
?>