<?php
class User {
    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $active;
    public $activationcode;
    public $logboek = [];
    public $internship = [];
    

    function __construct($id) {
        $this->id = $id;
    }
}