<?php

function gen1() {
    yield '1';
    yield '2';
    yield '3';
}

function gen2() {
    yield '4';
    yield '5';
    yield '6';
}

function gen3() {
    yield '7';
    yield '8';
    yield from gen1();
    yield '9';
    yield from gen2();
    yield '10';
}

// 123
foreach (gen1() as $number) {
    //echo $number;
}

// 78123945610
foreach (gen3() as $number) {
    echo $number;
}
