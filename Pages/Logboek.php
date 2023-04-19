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
$user = $studentService->getUserBy(['id' => $_SESSION['userId']]);

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
</head>

<body>

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
      'stageId' => $user->internship->id,
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
  <?php if (isset($_GET["id"])) :
    $logService->ReturnTasksByDayId($internship, intval($_GET["id"])); ?>
    <button type="button" data-toggle="modal" data-target="#myModal">Taak toevoegen</button>
  <?php endif; ?>
  <?php
  echo $internship->company;
  echo "<br>";
  $totalHours = $logService->ReturnTotalWorkHours($internship);
  echo $totalHours . "/800";
  
  ?>
  <div class="progress" role="progressbar" aria-label="Success example" aria-valuemin="0" aria-valuemax="100">
    <div class="progress-bar bg-success" style="width: <?php echo $percentageHours = $totalHours/800*100;?>%"><?php echo $percentageHours;?>%</div>
  </div>

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
  $taken = $_POST['taken'];
  $uren = $_POST['uren'];
  $tags = $_POST['tags'];


  $table = "taken";
  $data = [
    'taak' => $taken,
    'uur' => $uren,
  ];

  if ($taakinsert = DB::insert($table, $data)) {
    echo "<script>alert('Taak is toegevoegd')</script>";?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">
  <?php
    //als het al bestaat, dan wordt de docent teruggestuurd naar de pagina met ingevulde 
    //voornaam en achternaam, maar de email is dan leeg.
  } else {
    echo "<script>alert('Het is niet gelukt om een taak toe te voegen, probeer later opnieuw!')</script>";
  ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">
<?php
  }

  //Insert naar tabel taken
  $table = "taken"; //Welke table je insert
  $data = [];
  $result = DB::select($table, $data);
  $laatstetaakid = end($result)['id'];

  //Insert naar koppeltabel takentags
  $table = "koppeltakentags";
  $koppeltakentagsdata = [
    'takenId' => $laatstetaakid,
    'tagId' => $tags,
  ];
  $taakinsert = DB::insert($table, $koppeltakentagsdata);


  //Insert naar koppeltakenwerkdag

  $today = date('Y-m-d');
  $table = "werkdag";
  $data = [];
  $result = DB::select($table, $data);
  $check = array_search($today, array_column($result, 'datum'));
  $werkdagidoftoday = $result[$check]['id'];

  $table = "koppeltakenwerkdag";
  $data = [
    'taakId' => $laatstetaakid,
    'werkdagId' => $werkdagidoftoday,
  ];
  $result = DB::insert($table, $data);

  
}
?>