<!DOCTYPE html>
<html lang="nl">

<?php
include("header.php");
?>



<body>
	<form method="post" action="">
		<label for="bedrijf">Bedrijf:</label>
		<input type="text" id="bedrijf" name="bedrijf" required>

		<label for="naam_leerling">Naam leerling:</label>
		<input type="text" id="naam_leerling" name="naam_leerling" required>

		<label for="naam_pb">Naam praktijkbegeleider:</label>
		<input type="text" id="naam_pb" name="naam_praktijkbegeleider" required>

		<label for="email_leerling">Email leerling:</label>
		<input type="email" id="email_leerling" name="email_leerling" required>

		<label for="email_bedrijf">Email bedrijf:</label>
		<input type="email" id="email_bedrijf" name="email_praktijkbegeleider" required>

		<label for="begindatum">Begindatum:</label>
		<input type="date" id="begindatum" name="begindatum" required>

		<label for="einddatum">Einddatum:</label>
		<input type="date" id="einddatum" name="einddatum" required>

		<input type="submit" value="Verstuur" name="verstuur">

	</form>

	<script>
		// Set min date for the end date input to the selected date on the begin date input
		document.getElementById("begindatum").addEventListener("change", function() {
			document.getElementById("einddatum").setAttribute("min", this.value);
		});
	</script>


</body>

</html>


<?php

use Controllers\DB;

if (isset($_POST['verstuur'])) {

	// Insert stage values into stage table
	$data = [
		[
			'naam' => $_POST['naam_leerling'],
			'email' => $_POST['email_leerling'],
			'role' => 1,
		],
		[
			'naam' => $_POST['naam_praktijkbegeleider'],
			'email' => $_POST['email_praktijkbegeleider'],
			'role' => 2,
		]
	];
	$table = "users";
	$praktijkbegeleiderID = DB::insert($table, $data);
	$studentID = $praktijkbegeleiderID - 1;

	$naaml = $_POST['naam_leerling'];
	$emaill = $_POST['email_leerling'];

	$data = [
		'bedrijf' => $_POST['bedrijf'],
		'praktijkbegeleiderId' => $praktijkbegeleiderID,
		'studentId' => $studentID,
		'startdatum' => $_POST['begindatum'],
		'einddatum' => $_POST['einddatum'],
	];
	$table = "stage";
	$stage = DB::insert($table, $data);

	$naamp = $_POST['naam_praktijkbegeleider'];
	$emailp = $_POST['email_praktijkbegeleider'];

	// // Send email to learner
	// $subject_leerling = 'stage';
	// $message_leerling = 'er is een stage aangemaakt op uw mail klik hier om u stage te bevestigen ';
	// $headers_leerling = 'From: noreply@example.com' . "\r\n";
	// mail($to_leerling, $subject_leerling, $message_leerling, $headers_leerling);

	// // Send email to company
	// $subject_bedrijf = 'stage';
	// $message_bedrijf = 'er is een stage met uw bedrijf aangemaakt klik hier om uw stage te bevestigen';
	// $headers_bedrijf = 'From: noreply@example.com' . "\r\n";
	// mail($to_bedrijf, $subject_bedrijf, $message_bedrijf, $headers_bedrijf);

	// Redirect to success page
	// header('Location: homedocent.php');

	$headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
    // Create email headers
    $headers .='X-Mailer: PHP/' . phpversion();

    $subject ="Er is een account voor je aangemaakt";
    
    $message ="<html><body>";
    $message .="Beste $naaml, "."<br/>";
    $message .="Er is een stage aangemaakt. Voordat je kan inloggen moet je het eerste een wachtwoord aanmaken, dan wordt je account pas geactiveerd. "."<br/><br/>";
    $message .="Met onderstaande knop word je naar andere pagina gestuurd om je wachtwoord aan te maken."."<br/><br/>";
    //veranderen de url als de hele website later onlinestaat
    $message .="<a href='localhost/stagetijd/pages/ActiveerAccount.php?activationcode=$guid'><button style='background-color:lime !important; box-shadow:0px 0px 2px 2px; border-radius:10px;'>Account activeren</button></a>"."<br/><br/>";
    $message .="Met vriendelijke groet, "."<br/>";
    $message .="<img src='https://lh3.googleusercontent.com/4CoybolZm3Xr1WNZbGPF_ZoUDR_Yn1NmWuo23yYHiZCdtkNm9GJKRQ5ugGJ5Y2zOWfSjGk5izMIDqh67=w378-h189-rw' style='width: 20%;'>";
    $message .="</body></html>";

    mail($emaill,$subject,$message,$headers);

	$headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
    // Create email headers
    $headers .='X-Mailer: PHP/' . phpversion();

    $subject ="Er is een account voor je aangemaakt";
    
    $message ="<html><body>";
    $message .="Beste $naamp, "."<br/>";
    $message .="Er is een stage aangemaakt. Voordat je kan inloggen moet je het eerste een wachtwoord aanmaken, dan wordt je account pas geactiveerd. "."<br/><br/>";
    $message .="Met onderstaande knop word je naar andere pagina gestuurd om je wachtwoord aan te maken."."<br/><br/>";
    //veranderen de url als de hele website later onlinestaat
    $message .="<a href='localhost/stagetijd/pages/ActiveerAccount.php?activationcode=$guid'><button style='background-color:lime !important; box-shadow:0px 0px 2px 2px; border-radius:10px;'>Account activeren</button></a>"."<br/><br/>";
    $message .="Met vriendelijke groet, "."<br/>";
    $message .="<img src='https://lh3.googleusercontent.com/4CoybolZm3Xr1WNZbGPF_ZoUDR_Yn1NmWuo23yYHiZCdtkNm9GJKRQ5ugGJ5Y2zOWfSjGk5izMIDqh67=w378-h189-rw' style='width: 20%;'>";
    $message .="</body></html>";

    if (mail($emailp,$subject,$message,$headers)){
      echo "<script>alert('Er zijn zowel voor leerling en praktijkbegeleider accounts aangemaakt, diegene krijgt een mail om zijn account te activeren')</script>";
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=stageaanmaken.php">
    <?php
      //als het al bestaat, dan wordt de docent teruggestuurd naar de pagina met ingevulde 
      //voornaam en achternaam, maar de email is dan leeg.
    }else{
      echo "<script>alert('Het is niet gelukt om een account aan te maken, probeer later opnieuw!')</script>";
    ?>
    <META HTTP-EQUIV="Refresh" CONTENT="0; URL=stageaanmaken.php">
    <?php
    }
}
