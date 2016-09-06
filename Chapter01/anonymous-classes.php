<?php

// EXAMPLE #1

$object = new class {
    public function hello($message)
    {
        return "Hello $message";
    }
};

echo $object->hello('PHP');


// EXAMPLE #2 (wont run actually, as $helper is some imaginary variable here)

$helper->sayHello(new class {
    public function hello($message) {
        return "Hello $message";
    }
});


// EXAMPLE #3

class TheClass {}
interface TheInterface {}
trait TheTrait {}

$object = new class('A', 'B', 'C') extends TheClass implements TheInterface {

    use TheTrait;

    public $A;
    private $B;
    protected $C;

    public function __construct($A, $B, $C)
    {
        $this->A = $A;
        $this->B = $B;
        $this->C = $C;
    }
};

var_dump($object);


// Example #4

class Outer
{
    private $prop = 1;
    protected $prop2 = 2;

    protected function outerFunc1()
    {
        return 3;
    }

    public function outerFunc2()
    {
        return new class($this->prop) extends Outer
        {
            private $prop3;

            public function __construct($prop)
        {
            $this->prop3 = $prop;
        }

            public function innerFunc1()
        {
            return $this->prop2 + $this->prop3 + $this->outerFunc1();
        }
        };
    }
}

echo (new Outer)->outerFunc2()->innerFunc1();

