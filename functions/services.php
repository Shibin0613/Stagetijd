<?php
include "header.php";
 use Controllers\DB;
class Services
{
    private $connection;

    // Constructor for Services
    function __construct($conn)
    {
        $this->connection = $conn;
    }
}

function accountVerwijderen($id_to_delete, $conn)
{
  
}
