<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',
                TextType::class,
                [
                    'label' => "Nom d'utilisateur",
                    'translation_domain' => false
                ]
            )
            ->add('password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                    'required' => true,
                    'first_options'  => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Tapez le mot de passe à nouveau'],
                    'translation_domain' => false
                ]
            )
            ->add('email',
                EmailType::class,
                [
                    'label' => 'Adresse email',
                    'translation_domain' => false
                ]
            )
            ->add('roles', ChoiceType::class,
                [
                    'label' => 'Rôle',
                    'choices' => [
                        'ROLE_ADMIN' => 'ROLE_ADMIN'
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'translation_domain' => false
                ]
            );
        ;
    }
}
