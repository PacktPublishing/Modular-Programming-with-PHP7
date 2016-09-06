<?php

interface User {
    public function getEmail();
    public function getName();
    public function getAge();
}

class Employee implements User {
    public function getEmail() {
        // Implementation...
    }

    public function getAge() {
        // Implementation...
    }
}
