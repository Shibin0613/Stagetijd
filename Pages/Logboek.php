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
    $startdatum = DB::select("SELECT startdatum FROM stage");
    $einddatum = DB::select("SELECT einddatum FROM stage");
    $startdatum=strtotime($startdatum[0]['startdatum']);
    $einddatum=strtotime($einddatum[0]['einddatum']);
    echo $einddatum;
    echo ($einddatum[0]['einddatum']-$startdatum[0]['startdatum']);
    ?>
    </body>
</html>
