<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
           // ->add('roles') roles à definir plus tard, fait planter le formulaire pour le moment
            ->add('password', RepeatedType::class, [
               'type' => PasswordType::class,
               'invalid_message' => 'The password fields must match.',
               'options' => ['attr' => ['class' => 'password-field']],
               'required' => false,
               'first_options'  => ['label' => ''],
               'second_options' => ['label' => ''],
               'mapped' => false,
           ])

            ->add('lastname')
            ->add('firstname')
            ->add('phoneNumber')
            ->add('isActive')
            ->add('campus',null, ['choice_label'=>'name'])
            ->add('activities',null, ['choice_label'=>'name'])
            ->add('photo', FileType::class, [
                'label' => 'Photo (jpeg,png file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                    
                ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
