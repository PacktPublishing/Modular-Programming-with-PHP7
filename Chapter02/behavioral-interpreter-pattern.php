<?php

interface MathExpression
{
    public function interpret(array $values);
}

class Variable implements MathExpression
{
    private $char;

    public function __construct($char)
    {
        $this->char = $char;
    }

    public function interpret(array $values)
    {
        return $values[$this->char];
    }
}

class Literal implements MathExpression
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function interpret(array $values)
    {
        return $this->value;
    }
}

class Sum implements MathExpression
{
    private $x;
    private $y;

    public function __construct(MathExpression $x, MathExpression $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function interpret(array $values)
    {
        return $this->x->interpret($values) + $this->y->interpret($values);
    }
}

class Product implements MathExpression
{
    private $x;
    private $y;

    public function __construct(MathExpression $x, MathExpression $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function interpret(array $values)
    {
        return $this->x->interpret($values) * $this->y->interpret($values);
    }
}

// Client
$expression = new Product(
    new Literal(5),
    new Sum(
        new Variable('c'),
        new Literal(2)
    )
);

echo $expression->interpret(array('c' => 3)); // 25
