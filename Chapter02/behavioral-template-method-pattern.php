<?php

abstract class Game
{
    private $playersCount;

    abstract function initializeGame();

    abstract function makePlay($player);

    abstract function endOfGame();

    abstract function printWinner();

    public function playOneGame($playersCount)
    {
        $this->playersCount = $playersCount;
        $this->initializeGame();
        $j = 0;
        while (!$this->endOfGame()) {
            $this->makePlay($j);
            $j = ($j + 1) % $playersCount;
        }
        $this->printWinner();
    }
}

class Monopoly extends Game
{
    public function initializeGame()
    {
        // Implementation...
    }

    public function makePlay($player)
    {
        // Implementation...
    }

    public function endOfGame()
    {
        // Implementation...
    }

    public function printWinner()
    {
        // Implementation...
    }
}

class Chess extends Game
{
    public function  initializeGame()
    {
        // Implementation...
    }

    public function  makePlay($player)
    {
        // Implementation...
    }

    public function  endOfGame()
    {
        // Implementation...
    }

    public function  printWinner()
    {
        // Implementation...
    }
}

$game = new Chess();
$game->playOneGame(2);

$game = new Monopoly();
$game->playOneGame(4);
