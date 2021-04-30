<?php

namespace App\Admin;

use App\Entity\Task;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class TaskAdmin extends AbstractAdmin
{

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $user = $this->getCurrentUser();
        $alias = $query->getRootAlias();

        $query->innerJoin($alias . '.user', 'u')
            ->andWhere('u = :user')
            ->setParameter('user', $user);


        return $query;
    }
    
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper->add('title')
            ->add('comment')
            ->add('date')
            ->add(
                'timeSpent',
                null,
                [
                    'attr' => [
                        'max' => Task::MAX_TIME_SPENT,
                    ],
                ]
            );

        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                /** @var Task $task */
                $task = $event->getForm()->getData();
                $task->setUser($this->getCurrentUser());
            }
        );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper->add('title')
            ->add('comment')
            ->add('date');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper->addIdentifier('title')
            ->add('comment')
            ->add('date');
    }

    protected function getCurrentUser(): User
    {
        return $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
    }
}
