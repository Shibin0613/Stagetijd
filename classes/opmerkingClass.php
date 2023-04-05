<?php
class Opmerking {
    public $id;
    public $comment;
    public $userId;

    function __construct($id) {
        $this->id = $id;
    }
}