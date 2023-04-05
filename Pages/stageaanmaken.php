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

	$data = [
		'bedrijf' => $_POST['bedrijf'],
		'praktijkbegeleiderId' => $praktijkbegeleiderID,
		'studentId' => $studentID,
		'startdatum' => $_POST['begindatum'],
		'einddatum' => $_POST['einddatum'],
	];
	$table = "stage";
	$stage = DB::insert($table, $data);

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
}
