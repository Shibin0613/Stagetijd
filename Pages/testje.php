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

<div class="parent">
  <div class="grid1">
    <h1>logboek</h1>




  </div>
  <div class="grid2">
    <h1>bedrijfs info</h1>


    <h1>statistiek</h1>
    <div id="piechart" style="width: 400px; height: 300px;"></div>
  </div>
</div>