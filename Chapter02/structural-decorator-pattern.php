<?php

interface LoggerInterface {
    public function log($message);
}

class Logger implements LoggerInterface {
    public function log($message) {
        file_put_contents('app.log', $message, FILE_APPEND);
    }
}

abstract class LoggerDecorator implements LoggerInterface {
    protected $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    abstract public function log($message);
}

class ErrorLoggerDecorator extends LoggerDecorator {
    public function log($message) {
        $this->logger->log('ERROR: ' . $message);
    }

}

class WarningLoggerDecorator extends LoggerDecorator {
    public function log($message) {
        $this->logger->log('WARNING: ' . $message);
    }
}

class NoticeLoggerDecorator extends LoggerDecorator {
    public function log($message) {
        $this->logger->log('NOTICE: ' . $message);
    }
}

$logger = new Logger();
$logger->log('Resource not found.');

$logger = new Logger();
$logger = new ErrorLoggerDecorator($logger);
$logger->log('Invalid user role.');

$logger = new Logger();
$logger = new WarningLoggerDecorator($logger);
$logger->log('Missing address parameters.');

$logger = new Logger();
$logger = new NoticeLoggerDecorator($logger);
$logger->log('Incorrect type provided.');
