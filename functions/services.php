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
            $this->getLogBy(['stageId' => $value["id"]], $internship);
            $user->internship[] = $internship;
        }
    }

    public function getLogBy($data, $internship)
    {
        $table = "logboek";
        $logQuery = DB::select($table, $data);
        foreach ($logQuery as $key => $value) {
            $log = new Logboek($value["id"]);
            $log->internshipId = $value["stageId"];
            $log->weekNumber = $value["weeknummer"];
            $log->monday = $this->getWorkDayBy(['id' => $value["maandagId"]]);
            $log->tuesday = $this->getWorkDayBy(['id' => $value["dinsdagId"]]);
            $log->wednesday = $this->getWorkDayBy(['id' => $value["woensdagId"]]);
            $log->thursday = $this->getWorkDayBy(['id' => $value["donderdagId"]]);
            $log->friday = $this->getWorkDayBy(['id' => $value["vrijdagId"]]);
            $log->approved = $value["goedgekeurd"];
            $internship->logboek[] = $log;
        }
    }

    public function getWorkDayBy($data)
    {
        $table = "werkdag";
        $workdayQuery = DB::select($table, $data);
        foreach ($workdayQuery as $key => $value) {
            $workday = new Werkdag($value["id"]);
            $workday->date = $value["datum"];
            $workday->sickHours = $value["ziek"];
            $workday->daysOff = $value["vrij"];
            $this->getTasksBy($value["id"], $workday);
            // $this->getCommentsBy(['stageId' => $value["id"]], $internship);

            return $workday;
        }
    }

    public function getTasksBy($data, $workday)
    {
        $taskQuery = DB::join(["werkdag", "koppeltakenwerkdag"], ["id", "taakId"], ["koppeltakenwerkdag", "taken"], [["werkdagId", "*"], ["id", "id as taken_id, taak, uur"]], ["werkdag.id", $data]);
        foreach ($taskQuery as $key => $value) {
            $taak = new Taak($value["id"]);
            $taak->task = $value["taak"];
            $taak->hour = $value["ziek"];
            $this->getTagsBy($value["taken_id"], $taak);
            $workday->task[] = $taak;
        }

    }

    public function getTagsBy($data, $taken)
    {
        $tagQuery = DB::join(["taken", "koppeltakentags"], ["id", "tagId"], ["koppeltakentags", "tags"], [["takenId", "*"], ["id", "id as tag_id, naam as naam"]], ["taken.id", $data]);
        foreach ($tagQuery as $key => $value) {
            $tag = new Tags($value["tag_id"]);
            $tag->name = $value["naam"];

            $taken->tags[] = $tag;
        }

        return $taken->tags;
    }
}


class LogService extends Services {

    public function DayLoop($day)
    {
       foreach ($day->task as $key => $value) {
        echo $value->task;
        echo "<br>";
       }
    }


}