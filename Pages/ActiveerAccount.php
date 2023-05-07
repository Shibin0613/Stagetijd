<?php
//voor het geval dat emailadres null is, dan wordt hij naar andere pagina gestuurd, en toont geen foutmelding 
include('../functions/services.php');
$accountActivateServices = new AccountActivateServices();

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
    <form action="" method="POST">
    <?php
        use Controllers\DB;
        $table = "users";
        $data = [
            'activationcode' => "$activationcode", 
        ];
        $email = DB::select($table, $data);

        ?>
        <label for="emailadres">Email:</label><br/>
        <label class="form-control" style="width:20%"><?php echo $email[0]['email'];?></label>
        <br/><br/>
        
        <?php

        $table = "users";
        $data = [
            'activationcode' => "$activationcode", 
        ];
        $result = DB::select($table, $data);
        
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

    if ($wachtwoord != $bevestigwachtwoord) {
        echo "<script>alert('De ingevoerde wachtwoorden komen niet overeen. Probeer het opnieuw.')</script>";
        exit();
    }else
    {
        $updatedpassword = $accountActivateServices->updatePassword();
        if($updatedpassword){
            echo "<script>alert('Je account is geactiveerd, je kan nu inloggen met je emailadres en wachtwoord')</script>";
            ?>
            <META HTTP-EQUIV="Refresh" CONTENT="0; URL=login.php">
            <?php
    }
}

}
?>