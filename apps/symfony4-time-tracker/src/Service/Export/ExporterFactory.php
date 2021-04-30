<?php

namespace App\Service\Export;

class ExporterFactory
{
    protected array $exporters = [];

    public function __construct(CSVExporter $CSVExporter)
    {
        $this->exporters['csv'] = $CSVExporter;
    }

    public function getExporter(string $type)
    {
        if (!array_key_exists($type, $this->exporters)) {
            throw new \Exception(sprintf('Export type %s not supported', $type));
        }

        return $this->exporters[$type];
    }

    public function addExporter(ExporterInterface $exporter, string $type)
    {
        $this->exporters[$type] = $exporter;
    }
}
