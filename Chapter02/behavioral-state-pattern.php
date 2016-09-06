<?php

interface Statelike
{
    public function writeName(StateContext $context, $name);
}

class StateLowerCase implements Statelike
{
    public function writeName(StateContext $context, $name)
    {
        echo strtolower($name);
        $context->setState(new StateMultipleUpperCase());
    }
}

class StateMultipleUpperCase implements Statelike
{
    private $count = 0;

    public function writeName(StateContext $context, $name)
    {
        $this->count++;
        echo strtoupper($name);
        /* Change state after StateMultipleUpperCase's writeName() gets invoked twice */
        if ($this->count > 1) {
            $context->setState(new StateLowerCase());
        }
    }
}

class StateContext
{
    private $state;

    public function setState(Statelike $state)
    {
        $this->state = $state;
    }

    public function writeName($name)
    {
        $this->state->writeName($this, $name);
    }
}

// Client
$stateContext = new StateContext();
$stateContext->setState(new StateLowerCase());
$stateContext->writeName('Monday');
$stateContext->writeName('Tuesday');
$stateContext->writeName('Wednesday');
$stateContext->writeName('Thursday');
$stateContext->writeName('Friday');
$stateContext->writeName('Saturday');
$stateContext->writeName('Sunday');
