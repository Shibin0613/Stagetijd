<?php include("header.php"); ?>

<!DOCTYPE html>
<html>

<head>
  <title>Docent toevoegen</title>
</head>

<body>
  <h2>Docent toevoegen</h2>

  <form method="POST" action="Mail.php">
    <label for="name">Naam:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>

    <input name="submit" type="submit" value="Submit">
  </form>
</body>

</html>

<?php

include "header.php";

use Controllers\DB;

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $role = 1;
  $active = 0;
  $guid = uniqid();
  $result1 = DB::insert("INSERT INTO `users` (`naam`, `email`, `role`, `active`, `activationcode`) VALUES (:naam, :email, :rol, :active, :activationcode)", ['naam' => $name, 'email' => $email, 'rol' => $role, 'active' => $active, 'activationcode' => $guid]);
}

?>
