<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',
                TextareaType::class,
                [
                    'label' => 'Titre',
                    'translation_domain' => false
                ]
            )
            ->add('content',
                TextareaType::class,
                [
                    'label' => 'Contenu',
                    'translation_domain' => false
                ]
            )
            //->add('author') ===> must be the user authenticated
        ;
    }
}
