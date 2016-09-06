<?php

declare(strict_types = 0); // weak type-checking
declare(strict_types = 1); // strict type-checking

function hint(int $A, float $B, string $C, bool $D)
{
    var_dump($A, $B, $C, $D);
}

hint(2, 4.6, 'false', true);
/* int(2) float(4.6) string(5) "false" bool(true) */

hint(2.4, 4, true, 8);
/* int(2) float(4) string(1) "1" bool(true) */

hint(2.4, 4, true, 8);
/* Fatal error: Uncaught TypeError: Argument 1 passed to hint() must be of the type integer, float given... */
