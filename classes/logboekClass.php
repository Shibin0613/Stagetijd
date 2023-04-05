<?php
class Stage {
    public $id;
    public $studentid;
    public $praktijkbegeleiderID;
    

    function __construct($id) {
        $this->id = $id;
    }
}