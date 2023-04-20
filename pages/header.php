<?php 
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['userId'] === null || $_SESSION['role'] === null){
    header("location: ../index.php");
}

require_once "../vendor/autoload.php";
use Controllers\DB;

DB::connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Styles/style.css">
    <script src="https://kit.fontawesome.com/42b6daea05.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="calendar.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  
</head>
<body>
    
<header class="header">
  <div class="header-container">
    <!-- moet nog naar index gelinkt worden -->
    <a href="#" class="logo">StageTijd</a>
    <nav class="nav">
      <ul class="nav-list">
        <li class="nav-item"><a href="home.php">home</a></li>
        <li class="nav-item"><a href="#">zijn</a></li>
        <li class="nav-item"><a href="#">goeie</a></li>
        <li class="nav-item"><a href="#">items</a></li>
        <li class="nav-item"><form action="" method="POST"><button name="uitlog">Uitloggen</button></form></li>
      </ul>
    </nav>
    <button class="nav-toggle" aria-label="Toggle navigation">
      <span class="nav-toggle__bar"></span>
      <span class="nav-toggle__bar"></span>
      <span class="nav-toggle__bar"></span>
    </button>
  </div>
</header>

</body>
</html>

<?php
if(isset($_POST['uitlog']))
{
  session_start();
  session_destroy();
  header("location:login.php");
  exit();
}

?>