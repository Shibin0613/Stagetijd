<?php

include "header.php";
use Controllers\DB;

$table = "users";
$data = [
    'role' => 1,
];
$result = DB::select($table, $data);

echo '
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>E-mail</th>
                    <th>verwijderen</th>
                </tr>
            </thead>
            <tbody>
';

foreach ($result as $row) {
    $id = $row['id'];
    echo '
        <tr>
            <td>'.$row['naam'].'<input type="hidden" name="id[]" value="'.$row['id'].'"></td>
            <td>'.$row['email'].'</td>
            <td><a href="?userId='.$id.'"><i class="fa-solid fa-trash"></i></a></td>
        </tr>
    ';
}

echo '
            </tbody>
        </table>
    </div>
';

?>