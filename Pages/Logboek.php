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

    $table = "stage";
    $data = [
    'id' => "1",
    ];
    
    $result = DB::select($table, $data);
    $startdatum=strtotime($result[0]['startdatum']);
    $einddatum=strtotime($result[0]['einddatum']);
    $verschil = $einddatum-$startdatum;
    $week = floor($verschil/(60*60*24*7));
    echo $week." weken";
    
    ?>

    
    <button type="button" data-toggle="modal" data-target="#myModal">Taak toevoegen</button>


    <table>
        <tr>
            <th>Maandag</th>
            <th>Dinsdag</th>
            <th>Woensdag</th>
            <th>Donderdag</th>
            <th>Vrijdag</th>
            <th>Uren</th>
        </tr>
        <tr>
            <?php
                $table = "logboek";
                $data = [
                'id' => "1",
                ];
                
                $result = DB::select($table, $data);
                $maandagid= $result[0]['maandagId'];
                $dinsdagid= $result[0]['dinsdagId'];
                $woensdagid= $result[0]['woensdagId'];
                $donderdagid= $result[0]['donderdagId'];
                $vrijdagid= $result[0]['vrijdagId'];

                $table = "koppeltakenwerkdag";
                $data = [
                    "werkdagId" => "$maandagid"
                ];
                $result = DB::select($table, $data);
                $taakid = $result[0]['taakId'];


                $table = "taken";
                $data = [
                    "id" => "$taakid"
                ];
                $result = DB::select($table, $data);
                ?>
            <td><?php echo $result[0]['taak']?></td>

            <td>asdasd</td>
            <td>asdasd</td>
            <td>asdasd</td>
            <td>asdasd</td>
            <td><?php echo $result[0]['uur']?></td>
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
            <?php
                //  list($retro1,$retro2) = explode('!@#$%',$rr['rrtekst']);
                echo "
                <form method='POST' action=''>
                    <br>
                    <p>Taak<br>
                    </p>
                    <textarea rows='4' cols='50'>
                    </textarea>
                    <br>
                    <p>Hoelang ben je daarmee bezig geweest?<br>
                    </p>
                    <input type='number' name='uren' required> uren
                    <br>
                    <p>Tags</p>
                    <select name='tags'>
                    <option>Schoolopdracht</option>
                    <option>Programmeren</option>
                    </select>
                    <button type='button' data-toggle='modal' data-target='#myModal'>Tags toevoegen</button>
                    <p>Datum</p>
                    <input type='date' name='datum' id='myDateInput' readonly>
                    <br>
                    <br>
                    <button type='submit' onclick='dailypopup()' name='dailyinlever'>Inleveren</button>
                    
                </form>
                ";
                ?>
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

</script>