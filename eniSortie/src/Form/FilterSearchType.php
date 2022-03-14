<?php

namespace App\Form;

use src\Form\model\FilterSearch;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus',EntityType::class,[
            'class'=>Campus::Class,
            'choice_label' => 'name'])   

            ->add('search' , SearchType::class, [
                'mapped'=>false,
                'attr' => array(
                    'placeholder' => 'Search by activity name' 
                ),
                'required' => false,
            ])   
            
            ->add('startDate' ,DateType::class, [
                'label' => 'activity start date',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])

            ->add('endDate', DateType::class, [
                'label' => 'activity end date',
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
           
            ->add('activityOrganizer', CheckboxType::class,[
                'label' => 'Sortie dont je suis l\'organisateur.trice',
                'required' => false,
            ])
            ->add('registedMeActivity', CheckboxType::class, [
                'label' => 'sortie aux quelles je suis inscrit.e',
                'required' => false,
            ])

            ->add('unregistedMeActivity', CheckboxType::class,[
                'label' => 'sortie aux quelles je ne suis pas inscrit.e',
                'required' => false,
            ])
            ->add('pastActivity', CheckboxType::class,[
                'label' => 'sortie passée',
                'required' => false,
            ])

                                   
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FilterSearch::class,
        ]);
    }
}
