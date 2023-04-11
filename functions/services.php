<?php
include_once('../classes/LogboekClass.php');
include_once('../classes/OpmerkingClass.php');
include_once('../classes/StageClass.php');
include_once('../classes/StageClass.php');
include_once('../classes/TagsClass.php');
include_once('../classes/TakenClass.php');
include_once('../classes/UserClass.php');
include_once('../classes/WerkdagClass.php');

include "header.php";
use Controllers\DB;
class Services
{
    // private $connection;

    // // Constructor for Services
    // function __construct($conn)
    // {
    //     $this->connection = $conn;
    // }

    
}

class StudentServices extends Services 
{
    public function getUserBy($data)
    {
        $table = "users";
        $userQuery = DB::select($table, $data);
        foreach ($userQuery as $key => $value) {
            $user = new User($value["id"]);
            $user->name = $value["naam"];
            $user->email = $value["email"];
            $user->password = $value["wachtwoord"];
            $user->role = $value["role"];
            $user->active = $value["active"];
            $user->activationcode = $value["activationcode"];
            $this->getInternshipBy(['studentId' => $value["id"]], $user);
        }
        return $user;

    }

    public function getInternshipBy($data, $user)
    {
        $table = "stage";
        $internshipQuery = DB::select($table, $data);
        foreach ($internshipQuery as $key => $value) {
            $internship = new Stage($value["id"]);
            $internship->company = $value["bedrijf"];
            $internship->supervisor = $value["praktijkbegeleiderId"];
            $internship->student = $value["studentId"];
            $internship->startDate = $value["startdatum"];
            $internship->endDate = $value["einddatum"];
            $internship->active = $value["active"];
            $this->getLogboekBy(['stageId' => $value["id"]], $internship);
            $user->internship[] = $internship;
        }
    }

    public function getLogboekBy($data, $internship)
    {
        $table = "logboek";
        $logQuery = DB::select($table, $data);
        var_dump($logQuery);
        foreach ($logQuery as $key => $value) {
            $log = new Logboek($value["id"]);
            $log->id = $value["bedrijf"];
            $log->internshipId = $value["praktijkbegeleiderId"];
            $log->weekNumber = $value["studentId"];
            $log->monday = $value["startdatum"];
            $log->tuesday = $value["einddatum"];
            $log->wednesday = $value["active"];
            $log->thursday = $value["active"];
            $log->friday = $value["active"];
            $log->approved = $value["active"];
            $this->getLogboekBy(['stageId' => $value["id"]], $internship);
            $internship->logboek[] = $log;
        }
    }

    public function getTagby($data, $taken)
    {
        $table = "tags";
        $tagQuery = DB::select($table, $data);

        foreach ($tagQuery as $row) {
            $tag = new Tags($row[0]);
            $tag->name = $row['1'];

            $taken->tags[] = $tag;
        }

        return $taken->tags;
    }

}

