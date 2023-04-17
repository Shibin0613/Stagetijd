<!--
Save this file as calendar.html

Save all three files (calendar.html, calendar.css and calendar.js)in the same folder
Open the html file with a web browser
-->

<?php 
include ("header.php");
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
    use Controllers\DB;
    ?>

    <?php 
    $table = "werkdag";
    $data = [
    
    ];
    $result = DB::select($table, $data);
    if($result['datum'] = new DateTime()){
    echo $result['id'];
    }
    ?>
  
    <?php
    $weeknummer = date('W');
    ?>

    <button type="button" data-toggle="modal" data-target="#myModal">Taak toevoegen</button>
    <?php 
    $table = "stage";
    $data = [
    'id' => "1",
    ];
    $result = DB::select($table, $data);
    
    if (isset($result[0]['startdatum'])){
      $startdatum=strtotime($result[0]['startdatum']);
      $einddatum=strtotime($result[0]['einddatum']);
      $verschil = $einddatum-$startdatum;
      $week = floor($verschil/(60*60*24*7));
      echo $week;
    }
    
    ?>
    </table>

    <table>
        <tr>
            <th>Weeknummer</th>
            <th>Maandag</th>
            <th>Dinsdag</th>
            <th>Woensdag</th>
            <th>Donderdag</th>
            <th>Vrijdag</th>
            <th>Uren</th>
        </tr>
        <tr>
          
          
            <td>
            <?php echo $weeknummer; ?>
            </td>
            <td>asdasdad</td>
            <td>12313d</td>
            <td>123131</td>
            <td>asdasd</td>
            <td>asdasd</td>
            <td>Uren in totaal</td>
        </tr>
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
            $data = [
            ];
            $tagsresult = DB::select($table, $data);
                foreach($tagsresult as $result)
                {
                  $tagid = $result['id'];
                  echo
                  "<option value='$tagid'>".$result['naam']."</option>"
                  ;}
                  ?>
          </select>
          <button type='button' data-toggle='modal' data-target='#myModal'>Tags toevoegen</button>
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

function checkdelete(){
  return confirm('Weet je zeker dat je deze daily willen verwijderen?');
}
var weeknummer = "<?php echo $weeknummer; ?>";
document.getElementById("weeknummer").innerHTML = weeknummer;

</script>

<?php 
if(isset($_POST['inleveren'])){
  $taken = $_POST['taken'];
  $uren = $_POST['uren'];
  $tags = $_POST['tags'];
  $datum = $_POST['datum'];

  //Insert naar werkdagtabel in een loop met aankomende 5 dagen
  if(date('D', $timestamp) === 'Mon'){

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
}

$table = "taken";
  $data = [
    'taak' => $taken,
    'uur' => $uren,
  ];
  
  if($taakinsert = DB::insert($table, $data))
  {
    echo "<script>alert('Taak is toegevoegd')</script>";
    ?>
    <!--<META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">-->
    <?php
      //als het al bestaat, dan wordt de docent teruggestuurd naar de pagina met ingevulde 
      //voornaam en achternaam, maar de email is dan leeg.
    }else{
      echo "<script>alert('Het is niet gelukt om een taak toe te voegen, probeer later opnieuw!')</script>";
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=logboek.php">
    <?php
  }

//Insert naar tabel taken
$table = "taken"; //Welke table je insert
$data = [
];
$result = DB::select($table, $data);
$laatstetaakid = end($result)['id']; 

//Insert naar koppeltabel takentags
$table = "koppeltakentags";
$data = [
  'takenId' => $laatstetaakid,
  'tagId' => $tags,
];
$taakinsert = DB::insert($table, $data);

//insert koppeltabel takenwerkdag
$table = "werkdag";
$data = [

];
$result = DB::select($table, $data);


$table="koppeltakenwerkdag";
$data = [
  'taakId' => $laatstetaakid,
];
  
}
?>