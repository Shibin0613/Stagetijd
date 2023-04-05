<?php
class Stage {
    public $id;
    public $date;
    public $tasks = [];
    public $sickHours;
    public $daysOff;

    function __construct($id) {
        $this->id = $id;
    }
}