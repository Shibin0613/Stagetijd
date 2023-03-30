<?php
    session_start();  
    $host = "localhost";  
    $username = "root";  
    $password = "";  
    $database = "stagetijd"; 
    try  
    {
         $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $error)
    {
        $message = $error->getMessage(); 
    }
    ?>