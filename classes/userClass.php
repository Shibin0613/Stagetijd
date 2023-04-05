<?php
class User {
    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $active;
    public $activationcode;

    function __construct($id) {
        $this->id = $id;
    }
}