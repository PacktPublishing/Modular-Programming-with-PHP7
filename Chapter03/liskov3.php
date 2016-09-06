<?php

class UsersCollection implements \Iterator {
    // Implementation...
}

interface UserList {
    public function getUsers();
}

class Emloyees implements UserList {
    public function getUsers() {
        $users = new UsersCollection();
        //...
        return $users;
    }
}

class Directors implements UserList {
    public function getUsers() {
        $users = array();
        //...
        return $users;
    }
}
