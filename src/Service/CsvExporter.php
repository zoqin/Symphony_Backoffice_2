<?php

namespace App\Service;

class CsvExporter
{
    public function export(array $dataRows, array $headers): string
    {
        if (empty($dataRows)) {
            throw new \InvalidArgumentException('Aucune donnée à exporter');
        }

        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, $headers);

        foreach ($dataRows as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $content;
    }
}
