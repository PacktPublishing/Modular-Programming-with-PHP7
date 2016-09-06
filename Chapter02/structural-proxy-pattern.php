<?php

interface ImageInterface {
    public function draw();
}

class Image implements ImageInterface {
    private $file;

    public function __construct($file) {
        $this->file = $file;
        sleep(5); // Imagine resource intensive image load
    }

    public function draw() {
        echo 'image: ' . $this->file;
    }
}

class ProxyImage implements ImageInterface {
    private $image = null;
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }

    public function draw() {
        if (is_null($this->image)) {
            $this->image = new Image($this->file);
        }

        $this->image->draw();
    }
}

// Client
$image = new Image('image.png'); // 5 seconds
$image->draw();

$image = new ProxyImage('image.png'); // 0 seconds
$image->draw();
