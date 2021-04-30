<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\ExportFormType;
use App\Repository\TaskRepository;
use App\Service\Export\ExporterFactory;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskController extends AbstractController
{
    protected ExporterFactory $exporterFactory;

    public function __construct(ExporterFactory $exporterFactory)
    {
        $this->exporterFactory = $exporterFactory;
    }

    /**
     * @return StreamedResponse
     *
     * @Route(
     *      "export/task/csv",
     *      name="export_task_csv",
     *     methods={"GET"}
     * )
     */
    public function exportTaskCsv(Request $request)
    {
        $form = $this->createForm(
            ExportFormType::class,
            null,
            []
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $formData = $form->getData();;
            $tasks = $this->getTaskRepository()->findByUserAndDateRange(
                $user,
                $formData['startDate'],
                $formData['endDate']
            );

            if (!$tasks) {
                throw new NotFoundHttpException('Tasks not found');
            }

            $content = $this->getExporter('csv')->export($tasks);

            $callback = function () use ($content) {
                echo $content;
            };
            return new StreamedResponse(
                $callback,
                200,
                [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' =>
                        sprintf('attachment; filename=%s', 'tasks_' . $user->getUsername() . '_' . time() . '.csv'),
                ]
            );
        }

        return $this->render(
            'export/export.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    protected function getExporter(string $type)
    {
        return $this->exporterFactory->getExporter($type);
    }

    protected function getTaskRepository(): TaskRepository
    {
        return $this->getDoctrine()->getRepository(Task::class);
    }
}
