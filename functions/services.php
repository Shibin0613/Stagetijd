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
            $taak->hour = $value["uur"];
            $this->getTagsBy($value["taken_id"], $taak);
            $workday->tasks[] = $taak;
        }
    }

    public function getTagsBy($data, $taken)
    {
        $tagQuery = DB::join(["taken", "koppeltakentags"], ["id", "tagId"], ["koppeltakentags", "tags"], [["takenId", "*"], ["id", "id as tag_id, naam as naam, userid as userid"]], ["taken.id", $data]);
        foreach ($tagQuery as $key => $value) {
            $tag = new Tags($value["tag_id"]);
            $tag->name = $value["naam"];
            $tag->tagUser = $value["userid"];

            $taken->tags[] = $tag;
        }

        return $taken->tags;
    }
}


class LogService extends Services
{

    public function insertTask()
    {
        $taken = $_POST['taken'];
        $uren = $_POST['uren'];

        $takentable = "taken";
        $takendata = [
            'taak' => $taken,
            'uur' => $uren,
        ];
        $taakinsert = DB::insert($takentable, $takendata);
        return $taakinsert;
    }

    public function addTagtoTask($laatstetaakid)
    {
        $tags = $_POST['tags'];
        $koppeltakentagstable = "koppeltakentags";
        $koppeltakentagsdata = [
            'takenId' => $laatstetaakid,
            'tagId' => $tags,
        ];
        $taakinsert = DB::insert($koppeltakentagstable, $koppeltakentagsdata);
    }

    public function addTasktoWorkday($laatstetaakid)
    {
        $today = $_GET['id'];
        $werkdagtable = "werkdag";
        $werkdagdata = [];
        $result = DB::select($werkdagtable, $werkdagdata);
        $check = array_search($today, array_column($result, 'id'));
        $werkdagidoftoday = $result[$check]['id'];


        $koppeltakenwerkdagtable = "koppeltakenwerkdag";
        $koppeltakenwerkdagdata = [
            'taakId' => $laatstetaakid,
            'werkdagId' => $werkdagidoftoday,
        ];
        $result = DB::insert($koppeltakenwerkdagtable, $koppeltakenwerkdagdata);
    }

    public function getTagsInAddTask()
    {
        $table = "tags";
        $data = [];
        $tagsresult = DB::select($table, $data);
        foreach ($tagsresult as $result) {
            $tagid = $result['id'];
            echo
            "<option value='$tagid'>" . $result['naam'] . "</option>";
        }
    }

    public function createLogboekWeek($internship)
    {

        $weeknummer = date('W');
        $table = "logboek";
        $data = [];
        $result = DB::select($table, $data);
        $weeknrfromdatabase = end($result)['weeknummer'];
        //Insert naar werkdagtabel in een loop met aankomende 5 dagen als het weer maandag is

        if ($weeknrfromdatabase != $weeknummer) {
            $table = "werkdag";
            $date = new DateTime();
            for ($i = 0; $i < 5; $i++) { // loop 5 times
                $data = [
                    'datum' => $date->format('Y-m-d'),
                    'ziek' => '0',
                    'vrij' => '0',
                ];
                $date->add(new DateInterval('P1D')); // add 1 day to the date
                $werkdaginsert = DB::insert($table, $data);
            }
            //Vanuit database de werkdag uit om in koppeltabel Logboek te inserten
            $table = "werkdag";
            $data = [];
            $result = DB::select($table, $data);
            $laatstewerkdagid = end($result)['id'];
            $tweedelaatstewerkdagid = (end($result)['id']) - 1;
            $derdelaatstewerkdagid = (end($result)['id']) - 2;
            $vierdelaatstewerkdagid = (end($result)['id']) - 3;
            $vijfdelaatstewerkdagid = (end($result)['id']) - 4;


            $table = "logboek";
            $data = [
                'stageId' => $internship->id,
                'weeknummer' => $weeknummer,
                'maandagId' => $vijfdelaatstewerkdagid,
                'dinsdagId' => $vierdelaatstewerkdagid,
                'woensdagId' => $derdelaatstewerkdagid,
                'donderdagId' => $tweedelaatstewerkdagid,
                'vrijdagId' => $laatstewerkdagid,
            ];
            $result = DB::insert($table, $data);
        }
    }

    public function getFirstUserFromSupervisor($PBId)
    {
        $stageQuery = DB::select('stage', ['praktijkbegeleiderId' => $PBId]);
        return $stageQuery[0]['studentId'];
    }

    public function ReturnTasksByDayId($internship, $id, $role)
    {
        foreach ($internship->logboek as $key => $log) :
            if ($log->monday->id === $id) :
                foreach ($log->monday->tasks as $key => $task) :
                    echo $task->task;
                    if ($role === 3 || $role === 1) {
                    }
                    echo "<br>";
                endforeach;
                break;
            elseif ($log->tuesday->id === $id) :
                foreach ($log->tuesday->tasks as $key => $task) :
                    echo $task->task;
                    if ($role === 3 || $role === 1) {
                    }
                    echo "<br>";
                endforeach;
                break;
            elseif ($log->wednesday->id === $id) :
                foreach ($log->wednesday->tasks as $key => $task) :
                    echo $task->task;
                    if ($role === 3 || $role === 1) {
                    }
                    echo "<br>";
                endforeach;
                break;
            elseif ($log->thursday->id === $id) :
                foreach ($log->thursday->tasks as $key => $task) :
                    echo $task->task;
                    if ($role === 3 || $role === 1) {
                    }
                    echo "<br>";
                endforeach;
                break;
            elseif ($log->friday->id === $id) :
                foreach ($log->friday->tasks as $key => $task) :
                    echo $task->task;
                    if ($role === 3 || $role === 1) {
                    }
                    echo "<br>";
                endforeach;
                break;
            endif;
        endforeach;
    }

    public function ReturnTotalWorkHours($internship)
    {
        $Totalhour = 0;
        foreach ($internship->logboek as $key => $log) :
            foreach ($log->monday->tasks as $key => $task) :
                $Totalhour += $task->hour;
            endforeach;

            foreach ($log->tuesday->tasks as $key => $task) :
                $Totalhour += $task->hour;

            endforeach;

            foreach ($log->wednesday->tasks as $key => $task) :
                $Totalhour += $task->hour;

            endforeach;

            foreach ($log->thursday->tasks as $key => $task) :
                $Totalhour += $task->hour;

            endforeach;

            foreach ($log->friday->tasks as $key => $task) :
                $Totalhour += $task->hour;

            endforeach;

        endforeach;
        return $Totalhour;
    }

    public function getTagHours($internship)
    {
        $tagQuery = DB::select('tags', [
            'userId' => $_SESSION['logUserId']
        ]);
        foreach ($tagQuery as $key => $value) :
            $tagHours = 0;
            foreach ($internship->logboek as $key => $log) :
                foreach ($log->monday->tasks as $key => $task) :
                    if ($task->tags === $value) :
                        $tagHours += $task->hour;
                    endif;
                endforeach;

                foreach ($log->tuesday->tasks as $key => $task) :
                    if ($task->tags === $value) :
                        $tagHours += $task->hour;
                    endif;

                endforeach;

                foreach ($log->wednesday->tasks as $key => $task) :
                    if ($task->tags === $value) :
                        $tagHours += $task->hour;
                    endif;
                endforeach;

                foreach ($log->thursday->tasks as $key => $task) :
                    if ($task->tags === $value) :
                        $tagHours += $task->hour;
                    endif;
                endforeach;

                foreach ($log->friday->tasks as $key => $task) :
                    if ($task->tags === $value) :
                        $tagHours += $task->hour;
                    endif;
                endforeach;

            endforeach;
        endforeach;
        return $tagHours;
    }

    public function insertComment()
    {
        $opmerking = $_POST['opmerking'];

        $opmerkingtable = "opmerkingen";
        $opmerkingdata = [
            'opmerking' => $opmerking,
            'userId' =>  $_SESSION['logUserId'],

        ];
        $opmerkinginsert = DB::insert($opmerkingtable, $opmerkingdata);
        return $opmerkinginsert;
    }

    public function addCommenttoWorkday($laatsteopmerkingid)
    {
        $werkdagid = $_GET['id'];
        $koppelwerkdagopmerkingtable = "koppelwerkdagopmerking";
        $koppelwerkdagopmerkingdata = [
            'werkdagId' => $werkdagid,
            'opmerkingId' => $laatsteopmerkingid,
        ];
        $taakinsert = DB::insert($koppelwerkdagopmerkingtable, $koppelwerkdagopmerkingdata);
    }

    public function ReturncommentByDayId()
    {
        $koppelwerkdagopmerkingtable = "koppelwerkdagopmerking";
        $koppelwerkdagopmerkingdata = [
            "werkdagId" => $_GET['id'],
        ];
        $opmerkingid = DB::select($koppelwerkdagopmerkingtable,$koppelwerkdagopmerkingdata);
        if (isset($opmerkingid[0]['opmerkingId'])){
            $opmerkingid = $opmerkingid[0]['opmerkingId'];
            $opmerkingtable = "opmerkingen";
            $opmerkingdata = [
                'id' => $opmerkingid,
            ];
            $result = DB::select($opmerkingtable,$opmerkingdata);
            echo "Opmerking:".$result[0]['opmerking'];
        }else{
        }
    }
}




class AccountOverviewServices extends Services
{
    public function Filter()
    {
        if (!isset($_SESSION['roleUserFilter']) && !isset($_SESSION['activeUserFilter'])) {
            $_SESSION['roleUserFilter'] = 1;
            $_SESSION['activeUserFilter'] = 1;
        }
        if (isset($_POST['role_filter']) && isset($_POST['active_filter'])) {
            if ($_SESSION['roleUserFilter'] !== $_POST['role_filter']) {
                $_SESSION['roleUserFilter'] = $_POST['role_filter'];
            }
            if ($_SESSION['activeUserFilter'] !== $_POST['active_filter']) {
                $_SESSION['activeUserFilter'] = $_POST['active_filter'];
            }
        }
        $table = "users";
        $data = [
            'active' => $_SESSION['activeUserFilter'],
            'role' => $_SESSION['roleUserFilter'],
        ];
        $result = DB::select($table, $data);
        return $result;
    }
}

class AccountActivateServices extends Services
{
    public function updatePassword(){
        $activationcode = $_GET['activationcode'];
        $wachtwoord = $_POST['wachtwoord'];
        $bevestigwachtwoord = $_POST['bevestigwachtwoord'];
        $active = 1;

        $updatepassword = DB::update("UPDATE `users` SET wachtwoord = '$wachtwoord', active ='$active' WHERE activationcode ='$activationcode'");
        return $updatepassword;
    }
}

