<?php

// Syntax
$$foo['bar']['baz']
// PHP 5.x:
// Using a multidimensional array value as variable name
${$foo['bar']['baz']}
// PHP 7:
// Accessing a multidimensional array within a variable-variable
($$foo)['bar']['baz']

// Syntax
$foo->$bar['baz']
// PHP 5.x:
// Using an array value as a property name
$foo->{$bar['baz']}
// PHP 7:
// Accessing an array within a variable-property
($foo->$bar)['baz']

// Syntax
$foo->$bar['baz']()
// PHP 5.x:
// Using an array value as a method name
$foo->{$bar['baz']}()
// PHP 7:
// Calling a closure within an array in a variable-property
($foo->$bar)['baz']()

// Syntax
Foo::$bar['baz']()
// PHP 5.x:
// Using an array value as a static method name
Foo::{$bar['baz']}()
// PHP 7:
// Calling a closure within an array in a static variable
(Foo::$bar)['baz']()


// Access a static property on a string class name
// or object inside an array
$foo['bar']::$baz;
// Access a static property on a string class name or object
// returned by a static method call on a string class name
// or object
$foo::bar()::$baz;
// Call a static method on a string class or object returned by
// an instance method call
$foo->bar()::baz();


// Call a callable returned by a function
foo()();
// Call a callable returned by an instance method
$foo->bar()();
// Call a callable returned by a static method
Foo::bar()();
// Call a callable return another callable
$foo()();

// Access an array key
(expression)['foo'];
// Access a property
(expression)->foo;
// Call a method
(expression)->foo();
// Access a static property
(expression)::$foo;
// Call a static method
(expression)::foo();
// Call a callable
(expression)();
// Access a character
(expression){0};
