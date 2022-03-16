<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Campus;
use App\Entity\Location;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label'=>'Nom',
                'required'=>false
            ])
            ->add('startDate', DateTimeType::class,[
                'label'=>'Date de l\'activité',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                    ]
            ])
            ->add('activityDuration',IntegerType::class,[
                'label'=>'Durée de l\'activité',
            ])
            ->add('registrationDeadline', DateType::class,[
                'label'=>'Date limite d\'inscription',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                   
                ]
            ])
            ->add('nbRegistration', IntegerType::class,[
                'label'=>'Nombre de places',
            ])
            ->add('activityDescription', TextType::class,[
                'label'=>'Description et information',
            ])
            ->add('location',EntityType::class,            
            [
                'label'=>'Lieu',
                'class'=>Location::class,
                'choice_label'=>'name'])
            ->add('status', EntityType::class,
                [
                    'label'=>'Etat',
                    'class'=>Status::class,
                    'choice_label'=>'wording'
                ])
            ->add('campus' , EntityType::class,[
                'label'=>'Campus',
                'class'=>Campus::class,
                'choice_label'=>'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
