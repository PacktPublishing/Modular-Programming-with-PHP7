<?php

interface ExporterFactoryInterface {
    public function buildForFormat($format);
}

interface ExporterInterface {
    public function export($data);
}

class CsvExporter implements ExporterInterface {
    public function export($data) {
        // Implementation...
    }
}

class XmlExporter implements ExporterInterface {
    public function export($data) {
        // Implementation...
    }
}

class GenericExporter {
    private $exporterFactory;

    public function __construct(ExporterFactoryInterface $exporterFactory) {
        $this->exporterFactory = $exporterFactory;
    }

    public function exportToFormat($data, $format) {
        $exporter = $this->exporterFactory->buildForFormat($format);
        return $exporter->export($data);
    }
}

class ExporterFactory implements ExporterFactoryInterface {
    private $factories = array();

    public function addExporterFactory($format, callable $factory) {
        $this->factories[$format] = $factory;
    }

    public function buildForFormat($format) {
        $factory = $this->factories[$format];
        $exporter = $factory(); // the factory is a callable

        return $exporter;
    }
}

// Client
$exporterFactory = new ExporterFactory();

$exporterFactory->addExporterFactory(
    'xml',
    function () {
        return new XmlExporter();
    }
);

$exporterFactory->addExporterFactory(
    'csv',
    function () {
        return new CsvExporter();
    }
);

$data = array(/* ... some export data ... */);
$genericExporter = new GenericExporter($exporterFactory);
$csvEncodedData = $genericExporter->exportToFormat($data, 'csv');
