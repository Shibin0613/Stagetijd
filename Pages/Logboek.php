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
    $weeknummer = date('W');
    ?>
    
    <button type="button" data-toggle="modal" data-target="#myModal">Taak toevoegen</button>


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
            <?php
            echo $weeknummer;
            ?>
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
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <form method='POST' action=''>
            <br>
            <p>Taak</p>
            <textarea rows='4' cols='50' name='taken'>

            </textarea>
            <br>
            <p>Hoelang ben je daarmee bezig geweest?<br>
          </p>
          <input type='number' name='uren' required> uren
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

  $table = "taken";
  $data = [
    'taak' => $taken,
    'uur' => $uren,
  ];
  $taakinsert = DB::insert($table, $data);
   


}
?>