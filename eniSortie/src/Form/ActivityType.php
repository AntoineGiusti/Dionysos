<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Campus;
use App\Entity\Location;
use App\Entity\Participant;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('startDate')
            ->add('activityDuration')
            ->add('registrationDeadline')
            ->add('nbRegistration')
            ->add('activityDescription')

            ->add('location',EntityType::class,            
            [
                'class'=>Location::class,
                'choice_label'=>'name'])

            ->add('status', EntityType::class,
            [
                'class'=>Status::class,
                'choice_label'=>'wording'
            ])

            ->add('campus' , EntityType::class,[
                'class'=>Campus::class,
                'choice_label'=>'name'

            ]);

            // ->add('organizer', IntegerType::class,[
            //     'class'=>Activity::class,
            //     'choice_label'=>'organizer_id'
            // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
