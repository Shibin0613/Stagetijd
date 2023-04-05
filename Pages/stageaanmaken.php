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
		<input type="text" id="naam_leerling" name="naam" required>

		<label for="naam_pb">Naam praktijkbegeleider:</label>
		<input type="text" id="naam_pb" name="naam" required>

		<label for="email_leerling">Email leerling:</label>
		<input type="email" id="email_leerling" name="email_leerling" required>

		<label for="email_bedrijf">Email bedrijf:</label>
		<input type="email" id="email_bedrijf" name="email_bedrijf" required>

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
// Replace these placeholders with your own values
$host = 'localhost';
$dbname = 'stagetijd';
$username = 'root';
$password = '';
// $to_leerling = 'learner@example.com';
// $to_bedrijf = 'company@example.com';
use Controllers\DB;
if(isset($_POST['verstuur'])){
		// Connect to database using PDO
		$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Insert student and PB names into users table
		$naam = $_POST['naam'];
		$email = $_POST['email_leerling'];

		$insert_users = $db->prepare("INSERT INTO users (naam, email) VALUES (:naam, :email)");
		$insert_users->bindParam(':naam', $naam);
		$insert_users->bindParam(':email', $email);

		
		$insert_users->execute();

		// Insert stage values into stage table
		$last_id = $db->lastInsertId();
		$insert_stage = $db->prepare("INSERT INTO stage (bedrijf, startdatum, einddatum) VALUES (:bedrijf, :begindatum, :einddatum)");
		$insert_stage->bindParam(':bedrijf', $_POST['bedrijf']);
		$insert_stage->bindParam(':begindatum', $_POST['begindatum']);
		$insert_stage->bindParam(':einddatum', $_POST['einddatum']);
		$insert_stage->execute();

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
		exit;
	
    } 
    
     else {
        echo  $_POST['verstuur']  ;
     }
