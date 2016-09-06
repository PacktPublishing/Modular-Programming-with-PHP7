<?php

class Car {
    public function getWheels() {
        /* implementation... */
    }

    public function setWheels($wheels) {
        /* implementation... */
    }

    public function getColour($colour) {
        /* implementation... */
    }

    public function setColour() {
        /* implementation... */
    }
}

interface CarBuilderInterface {
    public function setColour($colour);
    public function setWheels($wheels);
    public function getResult();
}

class CarBuilder implements CarBuilderInterface {
    private $car;

    public function __construct() {
        $this->car = new Car();
    }

    public function setColour($colour) {
        $this->car->setColour($colour);
        return $this;
    }

    public function setWheels($wheels) {
        $this->car->setWheels($wheels);
        return $this;
    }

    public function getResult() {
        return $this->car;
    }
}

class CarBuildDirector {
    private $builder;

    public function __construct(CarBuilder $builder) {
        $this->builder = $builder;
    }

    public function build() {
        $this->builder->setColour('Red');
        $this->builder->setWheels(4);

        return $this;
    }

    public function getCar() {
        return $this->builder->getResult();
    }
}

// Client
$carBuilder = new CarBuilder();
$carBuildDirector = new CarBuildDirector($carBuilder);
$car = $carBuildDirector->build()->getCar();
