<?php

namespace App\Form;

use App\Entity\Color;
use App\Entity\State;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StateForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => ['autofocus' => true],
                'label' => 'State name',
            ])
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'placeholder' => '-- Choose --',
                'choice_label' => 'name',
            ])->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => State::class,
        ]);
    }
}