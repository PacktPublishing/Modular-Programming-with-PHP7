<?php

// EXAMPLE 1

function gen() {
    yield 'A';
    yield 'B';
    yield 'C';

    return 'gen-return';
}

$generator = gen();

// object(Generator)#1 (0) { }
var_dump($generator);

// Fatal error
// var_dump($generator->getReturn());

// ABC
foreach ($generator as $letter) {
    echo $letter;
}

// string(10) "gen-return"
var_dump($generator->getReturn());



// EXAMPLE 2

if ($generator->valid() === false) {
    var_dump($generator->getReturn());
}
