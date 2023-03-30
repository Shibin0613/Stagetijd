<!DOCTYPE html>
<html>
  <head>
    <title>Insert Data into Database</title>
    <style>
      label {
        display: block;
        margin-bottom: 10px;
      }

      input[type="text"],
      select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
      }

      input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      input[type="submit"]:hover {
        background-color: #45a049;
      }
    </style>
  </head>
  <body>
    <h2>Docent toevoegen</h2>

    <form method="POST" action="">
      <label for="name">Naam:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email:</label>
      <input type="text" id="email" name="email" required>
    
      <input name="submit" type="submit" value="Submit">
    </form>
  </body>
</html>

<?php
include "dbconn.php";

  
  if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $role = 1;
  $active = 1;
    $sql = "INSERT INTO users (`naam`, `email`, `role`, `active`) VALUES ('$name', '$email', '$role', '$active')";
    $sql_run= mysqli_query($conn, $sql);
    if($sql_run){
      echo "<script>alert('docent is toegevoegd.')</script>";
  }else{
      echo "<script>alert('Het is niet gelukt')</script>";
  }


  }

?>
