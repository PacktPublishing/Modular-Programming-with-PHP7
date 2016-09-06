<?php

class User {
    public $name;
    public $email;
}

class Employee extends User {
    public function __construct() {
        $this->name = 'Johhn Doe';
        $this->email = 'john.doe@fake.mail';
    }

    public function info() {
        return sprintf('%s, %s', $this->name, $this->email);
    }

    public function __clone() {
        /* additional changes for (after)clone behaviour? */
    }
}

$employee = new Employee();
echo $employee->info();

$director = clone $employee;
$director->name = 'Jane Doe';
$director->email = 'jane.doe@fake.mail';
echo $director->info();
