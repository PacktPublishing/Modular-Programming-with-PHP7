<?php

interface LightBulbCommand {
    public function execute();
}

class LightBulbControl {
    public function turnOn() {
        echo 'LightBulb turnOn';
    }

    public function turnOff() {
        echo 'LightBulb turnOff';
    }
}

class TurnOnLightBulb implements LightBulbCommand {
    private $lightBulbControl;

    public function __construct(LightBulbControl $lightBulbControl) {
        $this->lightBulbControl = $lightBulbControl;
    }

    public function execute() {
        $this->lightBulbControl->turnOn();
    }
}

class TurnOffLightBulb implements LightBulbCommand {
    private $lightBulbControl;

    public function __construct(LightBulbControl $lightBulbControl) {
        $this->lightBulbControl = $lightBulbControl;
    }

    public function execute() {
        $this->lightBulbControl->turnOff();
    }
}

// Client
$command = new TurnOffLightBulb(new LightBulbControl());
$command->execute();
