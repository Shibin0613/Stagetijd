<!DOCTYPE html>
<html>
<head>
<title>Tagsoverzicht</title>
</head>
<body>
    <?php include "header.php";
    use Controllers\DB; 
    ?>

    <?
    $table = "tags";
    $data = [];
    $result = DB::select($table,$data);
    var_dump($result);
    ?>



</body>
</html>