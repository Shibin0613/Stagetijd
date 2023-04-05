<?php include("header.php"); ?>

<!DOCTYPE html>
<html>

<head>
  <title>Docent toevoegen</title>
</head>

<body>  
  <div class="container m-5">
      <form  class="docentToevoegen" method="POST" action="Mail.php">
        <h3 class="Docenth3">Docent toevoegen</h3>
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>

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
$lastInsertedId = DB::insert($table, $data);
}

?>
