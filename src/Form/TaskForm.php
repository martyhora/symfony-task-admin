<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => ['autofocus' => true],
                'label' => 'Task name',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'placeholder' => '-- Choose --',
                'choice_label' => 'username',
            ])
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'placeholder' => '-- Choose --',
                'choice_label' => 'name',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Task description',
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}