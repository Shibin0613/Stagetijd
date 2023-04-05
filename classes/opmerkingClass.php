<?php
class Opmerking {
    public $id;
    public $opmerking;
    public $userId;

    function __construct($id) {
        $this->id = $id;
    }
}