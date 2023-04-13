<?php
class Taak {
    public $id;
    public $tasks;
    public $hour;
    public $tags = [];

    function __construct($id) {
        $this->id = $id;
    }
}