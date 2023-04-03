<!DOCTYPE html>
<html lang="nl">

<?php 
include("header.php");
?>



<body>
<form method="post" action="">
    <label for="naam_leerling">Naam Leerling:</label>
    <input type="text" name="naam" id="naam_leerling">
    <label for="naam_bedrijf">Naam Bedrijf:</label>
    <input type="text" name="naam_bedrijf" id="naam_bedrijf">
    <label for="naam_pb">Naam PB:</label>
    <input type="text" name="naam_pb" id="naam_pb">
    <label for="email_leerling">Email Leerling:</label>
    <input type="email" name="email_leerling" id="email_leerling">
    <label for="email_bedrijf">Email Bedrijf:</label>
    <input type="email" name="email_bedrijf" id="email_bedrijf">
    <input type="submit" value="Submit">
</form>

</body>
</html>


<?php

use Controllers\DB;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam_leerling = $_POST['naam'];
    $naam_bedrijf = $_POST['naam_bedrijf'];
    $naam_pb = $_POST['naam_pb'];
    $email_leerling = $_POST['email_leerling'];
    $email_bedrijf = $_POST['email_bedrijf'];

    $result1 = DB::insert("INSERT INTO `users` (`naam`, `email`) VALUES (:naam, :email)", ['naam' => $naam, 'email' => $email_leerling ]);
    $result2 = DB::insert("INSERT INTO `users` (`naam`, `email`) VALUES (:naam, :email)", ['naam' => $naam, 'email' => $email_bedrijf ]);
    $result3 = DB::insert("INSERT INTO `stage` (`bedrijf`, `email`) VALUES (:naam, :email)", ['naam' => $naam, 'email' => $email ]);

    
    $to_leerling = $email_leerling;
    $to_bedrijf = $email_bedrijf;
    $subject_leerling = 'uw stage is aangemaakt';
    $message_leerling = 'klik op de "knop" om uw stage aantemaken';
    $subject_bedrijf = 'stage van <?php $naam_lerling ?>';
    $message_bedrijf = 'hierbij een bevesteging dat u een stage begint met een nieuwe leerling, 
    klik op de knop om verder te gaan';
    
    // Send emails
    mail($to_leerling, $subject_leerling, $message_leerling);
    mail($to_bedrijf, $subject_bedrijf, $message_bedrijf);
    
    // Redirect to success page
    header('Location: homepagina.php');
    exit();
}
?>
