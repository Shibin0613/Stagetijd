<?php include("header.php"); ?>

<!DOCTYPE html>
<html>

<head>
  <title>Docent toevoegen</title>
</head>

<body>  
  <div class="container m-5">
      <form  class="docentToevoegen" method="POST" action="">
        <h3 class="Docenth3">Docent toevoegen</h3>
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <input name="submit" type="submit" value="Voeg toe">
      </form>
  </div>
</body>

</html>

<?php

include "header.php";

use Controllers\DB;

if (isset($_POST['submit'])) {

  $data = [
    'naam' => $_POST['name'],
    'email' => $_POST['email'],
    'role' => 1,
    'active' => 0,
    'activationcode' => uniqid(),
];
$table = "users";
$guid=$data['activationcode'];

$naam = $_POST['name'];
$email = $_POST['email'];

$headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
    // Create email headers
    $headers .='X-Mailer: PHP/' . phpversion();

    $subject ="Er is een account voor je aangemaakt";
    
    $message ="<html><body>";
    $message .="Beste $naam, "."<br/>";
    $message .="Er is een account voor je aangemaakt."."<br/><br/>";
    $message .="Met onderstaande knop word je naar andere pagina gestuurd om je wachtwoord aan te maken."."<br/><br/>";
    //veranderen de url als de hele website later onlinestaat
    $message .="<a href='localhost/stagetijd/pages/ActiveerAccount.php?activationcode=$guid'><button style='background-color:lime !important; box-shadow:0px 0px 2px 2px; border-radius:10px;'>Account activeren</button></a>"."<br/><br/>";
    $message .="Met vriendelijke groet, "."<br/>";
    $message .="<img src='https://lh3.googleusercontent.com/4CoybolZm3Xr1WNZbGPF_ZoUDR_Yn1NmWuo23yYHiZCdtkNm9GJKRQ5ugGJ5Y2zOWfSjGk5izMIDqh67=w378-h189-rw' style='width: 20%;'>";
    $message .="</body></html>";

    if (mail($email,$subject,$message,$headers)){
      $lastInsertedId = DB::insert($table, $data);      
      echo "<script>alert('Er is een account aangemaakt, diegene krijgt een mail om zijn account te activeren')</script>";
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=DocentToevoegen.php">
    <?php
      //als het al bestaat, dan wordt de docent teruggestuurd naar de pagina met ingevulde 
      //voornaam en achternaam, maar de email is dan leeg.
    }else{
      echo "<script>alert('Het is niet gelukt om een account aan te maken, probeer later opnieuw!')</script>";
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=DocentToevoegen.php">
    <?php
    }

}

?>
