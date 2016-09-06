<?php

interface Shape {
    public function draw();
}

class Circle implements Shape {
    private $colour;
    private $radius;

    public function __construct($colour) {
        $this->colour = $colour;
    }

    public function draw() {
        echo sprintf('Colour %s, radius %s.', $this->colour, $this->radius);
    }

    public function setRadius($radius) {
        $this->radius = $radius;
    }
}

class ShapeFactory {
    private $circleMap;

    public function getCircle($colour) {
        if (!isset($this->circleMap[$colour])) {
            $circle = new Circle($colour);
            $this->circleMap[$colour] = $circle;
        }

        return $this->circleMap[$colour];
    }
}

// Client
$shapeFactory = new ShapeFactory();
$circle = $shapeFactory->getCircle('yellow');
$circle->setRadius(10);
$circle->draw();

$shapeFactory = new ShapeFactory();
$circle = $shapeFactory->getCircle('orange');
$circle->setRadius(15);
$circle->draw();

$shapeFactory = new ShapeFactory();
$circle = $shapeFactory->getCircle('yellow');
$circle->setRadius(20);
$circle->draw();
