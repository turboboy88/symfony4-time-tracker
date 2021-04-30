<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ExportFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('startDate', DateType::class)
            ->add('endDate', DateType::class)
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
    }
}
