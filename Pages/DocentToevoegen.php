<?php include("header.php"); ?>

<!DOCTYPE html>
<html>

<head>
  <title>Insert Data into Database</title>
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