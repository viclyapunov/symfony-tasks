<?php
// src/AppBundle/Form/TaskType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task', TextType::class)
            ->add('createdby', TextType::class, array('label' => 'Created by:'))
            ->add('dueDate', DateType::class)
            ->add('created', DateTimeType::class)
            ->add('updated', DateTimeType::class)
            ->add('completed', CheckboxType::class, array(
                'required' => false,
            ))
            ->add('save', SubmitType::class, array('label' => 'Save & close'));
    }
}
