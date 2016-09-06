<?php

class Memento
{
    private $state;

    public function __construct($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }
}

class Originator
{
    private $state;

    public function setState($state)
    {
        return $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function saveToMemento()
    {
        return new Memento($this->state);
    }

    public function restoreFromMemento(Memento $memento)
    {
        $this->state = $memento->getState();
    }
}

// Client - Caretaker
$savedStates = array();

$originator = new Originator();
$originator->setState('new');
$originator->setState('pending');
$savedStates[] = $originator->saveToMemento();
$originator->setState('processing');
$savedStates[] = $originator->saveToMemento();
$originator->setState('complete');
$originator->restoreFromMemento($savedStates[1]);
echo $originator->getState(); // processing
