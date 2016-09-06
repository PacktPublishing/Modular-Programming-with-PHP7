<?php

class ReportPool {
    public function include(Report $report) {
    	//
    }
}

$reportPool = new ReportPool();
$reportPool->include(new Report());

class Collection extends \ArrayAccess, \Countable, \IteratorAggregate {

    public function forEach(callable $callback) {
        //
    }
 
    public function list() {
        //
    }
 
    public static function new(array $items) {
        return new self($items);
    }
}
 
Collection::new(['var1', 'var2'])
    ->forEach(function($index, $item){ /* ... */ })
    ->list();
