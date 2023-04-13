<?php
class Taak {
    public $id;
    public $task;
    public $hour;
    public $tags = [];

    function __construct($id) {
        $this->id = $id;
    }
}