<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\User;
use App\Entity\Module;
use App\Entity\Site;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ModuleType extends AbstractType
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

            ->add(
                'formation',
                EntityType::class,
                [
                    'label' => 'Formation associée :',
                    'class' => Formation::class,
                    'choice_label' => function (Formation $formation): string {
                        return $formation->getIntitule();
                    }
                ]
            )

            ->add('user', EntityType::class, [
                'label' => 'Formateur :',
                'class' => User::class,
                'choice_label' => function (User $User): string {
                    return $User->getFullName();
                },
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.prenom', 'ASC');
                },
                'multiple' => false,
                'expanded' => false,
                'by_reference' => false,
            ])

            ->add(
                'site',
                EntityType::class,
                [
                    'label' => 'Site :',
                    'class' => Site::class,
                    'choice_label' => 'ville',
                    'query_builder' => function (EntityRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('t')
                            ->orderBy('t.ville', 'ASC');
                    },
                    'expanded' => false,
                    'multiple' => false,
                    'by_reference' => false,

                ]
            )
            ->add(
                'date_debut',
                DateType::class,
                [
                    'label' => 'Date de début :',
                    'required' => false
                ]
            )
            ->add(
                'date_fin',
                DateType::class,
                [
                    'label' => 'Date de fin :',
                    'required' => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
            'sanitize_html' => true
        ]);
    }
}
