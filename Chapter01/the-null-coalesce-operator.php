<?php

$check = (5 > 3) ? 'Correct!' : 'Faulty!'; // Correct!

$check = (5 < 3) ? 'Correct!' : 'Faulty!'; // Faulty!

$role = isset($_GET['role']) ? $_GET['role'] : 'guest';

$role = $_GET['role'] ?? 'guest';

$A = null; // or not set

$B = 10;

echo $A ?? 20; // 20

echo $A ?? $B ?? 30; // 10
