<?php

interface LoggerProcessor {
    public function log(LoggerInterface $logger);
}

class XmlLogger implements LoggerInterface {
    // Implementation...
}

class JsonLogger implements LoggerInterface {
    // Implementation...
}

class FileLogger implements LoggerInterface {
    // Implementation...
}

class Processor implements LoggerProcessor {
    public function log(LoggerInterface $logger) {
        if ($logger instanceof XmlLogger) {
            throw new \Exception('This processor does not work with XmlLogger');
        } else {
            // Implementation...
        }
    }
}
