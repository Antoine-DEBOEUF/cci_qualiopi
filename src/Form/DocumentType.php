<?php

namespace App\Form;

use App\Entity\Document;
use App\Entity\Session;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'titre',
                TextType::class,
                [
                    'label'
                ]
            )

            ->add(
                'document',
                FileType::class,
                []
            )
            ->add('formateur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'choice_label' => 'id',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
