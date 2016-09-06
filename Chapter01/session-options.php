<?php

// PHP 5
ini_set('session.name', 'THEAPP');
ini_set('session.cookie_lifetime', 3600);
ini_set('session.cookie_httponly', 1);
session_start();

// PHP 7
session_start([
    'name' => 'THEAPP',
    'cookie_lifetime' => 3600,
    'cookie_httponly' => 1
]);

session_start([
    'name' => 'THEAPP',
    'cookie_lifetime' => 3600,
    'cookie_httponly' => 1,
    'lazy_write' => 1
]);
