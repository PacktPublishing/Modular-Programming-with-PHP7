<?php

class CsvExporter {
    public function export($data) {
        // Implementation...
    }
}

class XmlExporter {
    public function export($data) {
        // Implementation...
    }
}

class GenericExporter {
    public function exportToFormat($data, $format) {
        if ('csv' === $format) {
            $exporter = new CsvExporter();
        } elseif ('xml' === $format) {
            $exporter = new XmlExporter();
        } else {
            throw new \Exception('Unknown export format!');
        }
        return $exporter->export($data);
    }
}
