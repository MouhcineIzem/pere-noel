<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'firstName'
            ])
            ->add('lastName',TextType::class, [
                'label' => 'lastName'
            ])
            ->add('username',TextType::class, [
                'label' => 'username'
            ])
            ->add('password',PasswordType::class, [
                'label' => 'password',
            ])
            ->add('sexe',ChoiceType::class, [
                'label' => 'genre',
                'choices' => [
                    "Choisir entre homme | femme" => [
                        'homme' => "homme",
                        'femme' => "femme"
                    ]
                ]
            ])
            ->add('dateDeNaissance',DateType::class, [
                'label' => 'date de naissance'
            ])
            ->add('submit',SubmitType::class, [
                'label' => "S'inscrire",
                'attr' => [
                    'class' => "btn btn-info btn-block"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
