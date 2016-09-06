<?php

interface MediatorInterface {
    public function fight();
    public function talk();
    public function registerA(ColleagueA $a);
    public function registerB(ColleagueB $b);
}

class ConcreteMediator implements MediatorInterface {
    protected $talk; // ColleagueA
    protected $fight; // ColleagueB

    public function registerA(ColleagueA $a) {
        $this->talk = $a;
    }

    public function registerB(ColleagueB $b) {
        $this->fight = $b;
    }

    public function fight() {
        echo 'fighting...';
    }

    public function talk() {
        echo 'talking...';
    }
}

abstract class Colleague {
    protected $mediator; // MediatorInterface
    public abstract function doSomething();
}

class ColleagueA extends Colleague {

    public function __construct(MediatorInterface $mediator) {
        $this->mediator = $mediator;
        $this->mediator->registerA($this);
    }

	public function doSomething() {
        $this->mediator->talk();
	}
}

class ColleagueB extends Colleague {

    public function __construct(MediatorInterface $mediator) {
        $this->mediator = $mediator;
        $this->mediator->registerB($this);
    }

    public function doSomething() {
        $this->mediator->fight();
    }
}

// Client
$mediator = new ConcreteMediator();
$talkColleague = new ColleagueA($mediator);
$fightColleague = new ColleagueB($mediator);

$talkColleague->doSomething();
$fightColleague->doSomething();
