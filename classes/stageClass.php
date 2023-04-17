<?php
class Stage {
    public $id;
    public $company;
    public $supervisor;
    public $student;
    public $startDate;
    public $endDate;
    public $active;
    public $logboek = [];


    function __construct($id) {
        $this->id = $id;
    }
}