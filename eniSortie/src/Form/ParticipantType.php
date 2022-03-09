<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
           // ->add('roles') roles à definir plus tard, fait planter le formulaire pour le moment
            ->add('password')
            ->add('lastname')
            ->add('firstname')
            ->add('phoneNumber')
            ->add('isActive')
            ->add('campus',null, ['choice_label'=>'name'])
            ->add('activities',null, ['choice_label'=>'name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
