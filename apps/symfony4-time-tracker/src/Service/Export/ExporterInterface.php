<?php

namespace App\Service\Export;

interface ExporterInterface
{
    public function export(array $data);
}
