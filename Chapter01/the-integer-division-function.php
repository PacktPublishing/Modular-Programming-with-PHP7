<?php

intdiv(5, 3); // int(1)
intdiv(-5, 3); // int(-1)
intdiv(5, -2); // int(-2)
intdiv(-5, -2); // int(2)
intdiv(PHP_INT_MAX, PHP_INT_MAX); // int(1)
intdiv(PHP_INT_MIN, PHP_INT_MIN); // int(1)

// following two throw error
intdiv(PHP_INT_MIN, -1); // ArithmeticError
intdiv(1, 0); // DivisionByZeroError
