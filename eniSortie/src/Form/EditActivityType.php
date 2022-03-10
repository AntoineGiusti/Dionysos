<?php

namespace App\Form;

use App\Entity\Activity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('')
            ->add('startDate')
            ->add('activityDuration')
            ->add('registrationDeadline')
            ->add('nbRegistration')
            ->add('activityDescription')
            ->add('location')
            ->add('status')
            ->add('campus')
            ->add('organizer')
            ->add('participant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
