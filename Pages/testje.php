<!DOCTYPE html>
<html lang="nl">
<?php 
include("header.php");
?>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=yes" />
    <link rel="stylesheet" type="text/css" href="calendar.css">
    <script type="text/javascript" src="calendar.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>

<div class="parent">
    <div class="grid1">
<h1>logboek</h1>
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
<br>
<br>
<h1>kalender</h1>



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
				var_dump($result);
                $maandagid= $result[0]['maandagId'];
                $dinsdagid= $result[0]['dinsdagId'];
                $woensdagid= $result[0]['woensdagId'];
                $donderdagid= $result[0]['donderdagId'];
                $vrijdagid= $result[0]['vrijdagId'];
				
				$table = "koppeltakenwerkdag";
                $data = [
                    "werkdagId" => "$maandagid",
					"werkdagId" => "$dinsdagid",
					"werkdagId" => "$woensdagid",
					"werkdagId" => "$donderdagid",
					"werkdagId" => "$vrijdagid",
                ];
                $result = DB::select($table, $data);
				echo "</br>";
				echo "</br>";
				var_dump($result);
				
				$taakid = $result[0]['taakId'];

                $table = "taken";
                $data = [
                    "id" => "$taakid"
                ];
                $result = DB::select($table, $data);
                ?>
            <td><?php echo $result[0]['taak']?></td>

            <td><?php echo $result[0]['taak']?></td>
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

    </div>
    <div class="grid2">
        <h1>bedrijfs info</h1>


        <h1>statistiek</h1>
        <div id="piechart" style="width: 400px; height: 300px;"></div>
    </div>
<body>
  </body>
</div>