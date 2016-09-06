<?php

class Logger {
    private static $instance;
    
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    public function logNotice($msg) {
        return 'logNotice' . $msg;
    }
    
    public function logWarning($msg) {
        return 'logWarning' . $msg;
    }
    
    public function logError($msg) {
        return 'logError: ' . $msg;
    }
}

// Client
echo Logger::getInstance()->logNotice('Test1');
echo Logger::getInstance()->logWarning('Test1');
echo Logger::getInstance()->logError('Test1');
