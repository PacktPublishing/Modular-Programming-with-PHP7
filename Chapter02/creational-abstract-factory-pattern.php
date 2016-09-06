<?php

interface Button {
    public function render();
}

interface GUIFactory {
    public function createButton();
}

class SubmitButton implements Button {
    public function render() {
        echo 'Render Submit Button';
    }
}

class ResetButton implements Button {
    public function render() {
        echo 'Render Reset Button';
    }
}

class SubmitFactory implements GUIFactory {
    public function createButton() {
        return new SubmitButton();
    }
}

class ResetFactory implements GUIFactory {
    public function createButton() {
        return new ResetButton();
    }
}

// Client
$submitFactory = new SubmitFactory();
$button = $submitFactory->createButton();
$button->render();

$resetFactory = new ResetFactory();
$button = $resetFactory->createButton();
$button->render();
