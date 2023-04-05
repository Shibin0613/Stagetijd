<?php
class Werkdag {
    public $id;
    public $date;
    public $sickHours;
    public $daysOff;
    public $tasks = [];
    public $comments = [];

    function __construct($id) {
        $this->id = $id;
    }
}