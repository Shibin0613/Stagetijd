<?php
class Logboek {
    public $id;
    public $internshipId;
    public $weekNumber;
    public $monday;
    public $tuesday;
    public $wednesday;
    public $thursday;
    public $friday;
    public $approved;


    function __construct($id) {
        $this->id = $id;
    }
}