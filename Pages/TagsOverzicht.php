<!DOCTYPE html>
<html>
<head>
<title>Tagsoverzicht</title>
</head>
<body>
    <?php include "header.php";
    use Controllers\DB; 
    ?>
    
    <div class='container m-5'>
    <form  class='docentToevoegen' method='POST' action=''>
    <h3 class='Docenth3'>Docent toevoegen</h3>
    <?php
    $table = "tags";
    $data = [];
    $where = "";
    $tags = DB::select($table,$data,$where);
    foreach($tags as $tagsnaam)
    {
        echo
        "<label for='name'>".$tagsnaam['naam']."</label><br>
        ";
    }
    ?>
    <label for="naam">Tags toevoegen
    <input type="text" id="name" name="tagsnaam" required>
    <input name="submit" type="submit" value="Voeg toe">
    <label>
    </form>
    </div>



</body>
</html>

<?php
if(isset($_POST['submit']))
{
    $tagsnaam = $_POST['tagsnaam'];
    
    $table="tags";
    $data=[
        'naam' => $tagsnaam,
    ];
    
    if ($result=DB::insert($table,$data)){
        echo "<script>alert('Tag is toegevoegd')</script>";
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0; URL=TagsOverzicht.php">
        <?php
        //als het al bestaat, dan wordt de docent teruggestuurd naar de pagina met ingevulde 
        //voornaam en achternaam, maar de email is dan leeg.
    }else{
        echo "<script>alert('Het is niet gelukt om een tag toe te voegen, probeer later opnieuw!')</script>";
        ?>
        <META HTTP-EQUIV="Refresh" CONTENT="0; URL=TagsOverzicht.php">
        <?php
    }
}

?>