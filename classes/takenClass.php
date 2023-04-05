<?php
class Stage {
    public $id;
    public $date;
    public $tasks;
    public $hour;
    public $tags = [];

    function __construct($id) {
        $this->id = $id;
    }
}