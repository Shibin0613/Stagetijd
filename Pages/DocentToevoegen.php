<?php include("header.php"); ?>

<!DOCTYPE html>
<html>

<head>
  <title>Docent toevoegen</title>
</head>

<body>  
  <div class="container m-5">
      <form method="POST" action="Mail.php">
        <h3 class="mb-4">Docent toevoegen</h3>
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>

        <input name="submit" type="submit" value="Voeg toe">
      </form>
  </div>
</body>

</html>