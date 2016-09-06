<?php

interface Appliance {
    public function powerOn();
    public function powerOff();
    public function bake();
    public function mix();
    public function wash();

}

class Oven implements Appliance {
    public function powerOn() { /* Implement ... */ }
    public function powerOff() { /* Implement ... */ }
    public function bake() { /* Implement... */ }
    public function mix() { /* Nothing to implement ... */ }
    public function wash() { /* Cannot implement... */ }
}

class Mixer implements Appliance {
    public function powerOn() { /* Implement... */ }
    public function powerOff() { /* Implement... */ }
    public function bake() { /* Cannot implement... */ }
    public function mix() { /* Implement... */ }
    public function wash() { /* Cannot implement... */ }
}

class WashingMachine implements Appliance {
    public function powerOn() { /* Implement... */ }
    public function powerOff() { /* Implement... */ }
    public function bake() { /* Cannot implement... */ }
    public function mix() { /* Cannot implement... */ }
    public function wash() { /* Implement... */ }
}
