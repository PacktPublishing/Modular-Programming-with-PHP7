<?php

define('FRAMEWORK', [
    'version' => 1.2,
    'licence' => 'enterprise'
]);

echo FRAMEWORK['version']; // 1.2
echo FRAMEWORK['licence']; // enterprise

// the class const example
class App {
    const FRAMEWORK = [
        'version' => 1.2,
        'licence' => 'enterprise'
    ];
}

echo App::FRAMEWORK['version']; // 1.2
echo App::FRAMEWORK['licence']; // enterprise
