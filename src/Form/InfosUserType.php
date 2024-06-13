<?php

namespace App\Form;


use App\Entity\InfosUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InfosUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nom',
                TextType::class,
                [
                    'label' => 'Nom :',
                    'required' => false
                ]
            )

            ->add(
                'prenom',
                TextType::class,
                [
                    'label' => 'Prénom(s) :',
                    'required' => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InfosUser::class,
            'sanitize_html' => true
        ]);
    }
}
