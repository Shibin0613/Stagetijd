<?php
include ("header.php");
//voor het geval dat emailadres null is, dan wordt hij naar andere pagina gestuurd, en toont geen foutmelding 


$activationcode = $_GET['activationcode'];

//Eventueel als de account al bestaat, dat hij zijn account niet meer kan activeren, dan werkt de link niet meer. 

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/gebruikertoevoegen.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<title>Account activeren</title>
</head>
<body>
    <?php 
    //haalt vanuit database welke emailadres het is met de goede activationcode

    
    ?>
    <div class="container">
    <br/><br/>
    <center><h4>Account activeren</h4><br/>
    <div class="form-group">
    <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar bg-success" style="width: 50%"><?php 50/100?></div>
    </div>
    <form action="" method="POST">
    <?php
        use Controllers\DB;
        $email = DB::select("SELECT email FROM users WHERE activationcode = :activationcode", ['activationcode' => $activationcode]);
        ?>
        <label for="emailadres">Email:</label><br/>
        <label class="form-control" style="width:20%"><?php echo $email[0]['email'];?></label>
        <br/><br/>
        
        <?php
        $result = DB::select("SELECT wachtwoord FROM users WHERE activationcode = :activationcode", ['activationcode' => $activationcode]);
        if(empty($result[0]['wachtwoord'])){
            echo "
                <label for='wachtwoord'>Wachtwoord:</label><br/>
                <input type='password' class='form-control' style='width:20%;font-size:10px;' name='wachtwoord' minlength='8' maxlength='20' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}' title='Minimaal 8 karakters, met een hoofdletter, kleinletter en een getal'>
                <label for='wachtwoord'>Bevestig wachtwoord:</label><br/>
                <input type='password' class='form-control' style='width:20%;font-size:10px;' name='bevestigwachtwoord' minlength='8' maxlength='20' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}' title='Minimaal 8 karakters, met een hoofdletter, kleinletter en een getal'>
                <br/><br/>
                <button name='activeren' class='btn btn-default' style='background-color:;'>Account activeren</button>
                ";
        }else{
            echo "Je account is geactiveerd, je kan door met <a href='login.php'>Inloggen</a>";
        }
    
        ?>

        
    <form>
    </div>   
    </center>
</div>

</body>
</html>

<?php 

if(isset($_POST['activeren'])){
    $wachtwoord = $_POST['wachtwoord'];
    $bevestigwachtwoord = $_POST['bevestigwachtwoord'];
    $active = 1;

    if ($wachtwoord != $bevestigwachtwoord) {
        echo "<script>alert('De ingevoerde wachtwoorden komen niet overeen. Probeer het opnieuw.')</script>";
        exit();
    }else
    {
        if(DB::update("UPDATE `users` SET wachtwoord = '$wachtwoord', active ='$active' WHERE activationcode ='$activationcode'")){
            echo "<script>alert('Je account is geactiveerd, je kan nu inloggen met je emailadres en wachtwoord')</script>";
            ?>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL=login.php">
            <?php
    }
}

}
?>