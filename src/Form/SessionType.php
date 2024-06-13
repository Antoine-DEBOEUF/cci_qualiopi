<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Session;
use App\Entity\InfosUser;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'intitule',
                TextType::class,
                [
                    'label' => 'Intitulé',
                    'required' => false
                ]
            )

            ->add('formateur', EntityType::class, [
                'label' => 'Formateur :',
                'class' => InfosUser::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('t')
                        ->andWhere('t.nom = :nom', 't.prenom= :prenom')
                        ->orderBy('t.nom', 'ASC');
                },
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false,
            ])

            ->add(
                'site',
                ChoiceType::class,
                [
                    'label' => 'Site :',
                    'choices' => [
                        'Lyon' => 'lyon',
                        'Roanne' => 'roanne',
                        'St-Etienne' => 'st-etienne'
                    ],
                    'expanded' => true,
                    'multiple' => true

                ]
            )
            ->add(
                'date_debut',
                NumberType::class,
                [
                    'label' => 'Date de début :',
                    'required' => false
                ]
            )
            ->add(
                'date_fin',
                NumberType::class,
                [
                    'label' => 'Date de fin :',
                    'required' => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
            'sanitize_html' => true
        ]);
    }
}
