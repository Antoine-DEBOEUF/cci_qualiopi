<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\InfosUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Email :',
                    'required' => false
                ]
            )

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'required' => false,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe :',

                    'constraints' => [
                        new Assert\Regex([
                            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                            'message' => 'Votre mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
                        ]),
                        new Assert\NotBlank(),
                        new Assert\Length(
                            max: 4096,
                        ),
                    ]
                ],
                'second_options' => [
                    'label' => 'Répéter le mot de passe :',

                ],
            ])

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

        if ($options['isAdmin']) {
            $builder->add(
                'roles',
                ChoiceType::class,
                [
                    'label' => 'Role :',
                    'choices' => [
                        'Formateur' => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN'
                    ],
                    'expanded' => true,
                    'multiple' => true


                ]
            )
                ->add(
                    'description',
                    TextType::class,
                    [
                        'label' => 'Description (facultative) :',
                        'required' => false,
                    ]
                );
        }
    }






    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false,
            'sanitize_html' => true,
        ]);
    }
}
