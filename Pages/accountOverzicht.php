<?php
include "header.php";
use Controllers\DB;
// Select all users with the correct role
$role = "1";
$result = DB::select("SELECT * FROM users WHERE `role` = :rol", ['rol' => $role]);



// Display users in boxes

if ($result) {
    foreach($result as $row) {
        // var_dump($row['naam']);
        echo '<div class="StudentOverzicht">' . $row["naam"] . '</div>';
    }
} else {
    echo "No users found.";
}

// Close connection

?>
