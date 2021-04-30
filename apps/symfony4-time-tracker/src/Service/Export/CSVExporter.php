<?php

namespace App\Service\Export;

use App\Entity\Task;
use App\Service\Export\Model\TaskData;
use App\Service\Export\Model\TasksData;
use Symfony\Component\Serializer\SerializerInterface;

class CSVExporter implements ExporterInterface
{
    protected SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array|Task[] $data
     * @return string
     */
    public function export(array $data)
    {
        $tasksData = [];
        $totalSpent = 0;
        foreach ($data as $task) {
            $tasksData[] = new TaskData($task);
            $totalSpent += $task->getTimeSpent();
        }

        $content = $this->serializeDataToCsv($tasksData);

        return $this->addTotalLine($content, $totalSpent);
    }

    protected function serializeDataToCsv($data): string
    {
        return $this->serializer->serialize($data, 'csv');
    }

    protected function addTotalLine($content, $total): string
    {
        return sprintf('%s%s ', $content, ',,total,' . $total);
    }
}
