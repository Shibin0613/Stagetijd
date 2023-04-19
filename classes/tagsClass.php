<?php
class Tags {
    public $id;
    public $name;
    public $tagUser;

    function __construct($id) {
        $this->id = $id;
    }
}