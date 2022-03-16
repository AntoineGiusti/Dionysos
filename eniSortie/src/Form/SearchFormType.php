<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Activity;
use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType

{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //Barre de recherche
            ->add('q', TextType::class, [
                'label'=>'Le nom de la sortie contient',
                 'required'=>false,
                'empty_data' => '',
                 'attr'=>[
                     'placeholder'=>'Rechercher'
                 ]
                ])
            ->add('campus', EntityType::class, [
                'label' => 'Campus',
                'placeholder'=>'Campus',
                'required'=>false,
                //Classe à utiliser
                'class'=> Campus::class,
            ])
            ->add('isOrganizer', CheckboxType::class, [
                'label'=> 'Sorties dont je suis l\'organisateur.ice',
                'required'=>false,
            ])
            ->add('isRegistered', CheckboxType::class, [
                'label'=> 'Sorties auxquelles je suis inscrit.e',
                'required'=>false,
                ])
            ->add('isNotRegistered', CheckboxType::class, [
                'label'=> 'Sorties auxquelles je ne suis pas inscrit.e',
                'required'=>false,
            ])

            ->add('passedActivity',CheckboxType::class,  [
                'label'    => 'Sorties passées',
                'required'      => false,
            ])

            //Entre DATE1 et DATE2
            ->add('date1', DateType::class, [
                'widget'=>'single_text',
                'required'=>false,
                'label'=>'Entre le ',
            ])
            ->add('date2', DateType::class, [
                'widget'=>'single_text',
                'required'=>false,
                'label'=>'et le ',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
        ]);
    }


}