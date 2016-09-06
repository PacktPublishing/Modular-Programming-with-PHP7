<?php

class Customer implements \SplSubject
{
    protected $data = array();
    protected $observers = array();

    public function attach(\SplObserver $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(\SplObserver $observer)
    {
        $index = array_search($observer, $this->observers);

        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
        $this->notify();
    }
}

class CustomerObserver implements \SplObserver
{
    public function update(\SplSubject $subject)
    {
        // TODO: Implement update() method.
    }
}

// Client
$user = new Customer();
$customerObserver = new CustomerObserver();

$user->attach($customerObserver);

$user->name = 'John Doe';
$user->email = 'john.doe@fake.mail';
