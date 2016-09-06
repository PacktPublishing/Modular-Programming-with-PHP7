<?php

abstract class User {
    private $email;
    private $age;

    public function getEmail() {
        return $this->email;
    }

    abstract public function getName();

    public function getAge() {
        return $this->age;
    }
}

class Employee extends User {

    /**
     * @override User :: getEmail;
     */
    public function getEmail() {
        $email = parent::getEmail();
        if (!$email) {
            throw new \Exception('Missing email!');
        }
    }
}
