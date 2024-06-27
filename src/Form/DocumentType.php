<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Module;
use App\Entity\Document;
use App\Entity\Formation;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfonycasts\DynamicForms\DependentField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotNull;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add(
                'categorie',
                ChoiceType::class,
                [
                    'label' => 'Catégorie :',
                    'choices' => [
                        'Support formateur' => 'support_formateur',
                        'Itinéraire pédagogique' => 'itin_pedago',
                        'ECF' => 'ecf',

                    ],
                    'expanded' => true,
                    'multiple' => false


                ]
            )

            // ->add(
            //     'formation',
            //     EntityType::class,
            //     [
            //         'label' => 'Formation associée :',
            //         'class' => Formation::class,
            //         'choice_label' => function (Formation $formation): string {
            //             return $formation->getIntitule();
            //         },
            //         'query_builder' => function (EntityRepository $er): QueryBuilder {
            //             return $er->createQueryBuilder('u')
            //                 ->orderBy('u.intitule', 'ASC');
            //         },
            //         'multiple' => false,
            //         'expanded' => false,
            //         'by_reference' => true,
            //     ]
            // )




            ->add(
                'module',
                EntityType::class,
                [
                    'label' => 'Module :',
                    'class' => Module::class,
                    'choice_label' => function (Module $module): string {
                        return $module->getIntitule();
                    },
                    'query_builder' => function (EntityRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('m')

                            ->orderBy('m.intitule', 'ASC');
                    }, 'multiple' => false,
                    'expanded' => false,
                    'by_reference' => true,
                    'constraints' => [
                        new NotNull(['message' => 'Sélectionnez le module associé à ce document'])
                    ]
                ]
            )



            ->add(
                'File',
                VichFileType::class,
                [
                    'label' => false,
                    'required' => false,
                    'allow_delete' => true,

                    // 'file_uri' => true,
                    'download_uri' => false,

                ]
            );

        if ($options['isAdmin']) {
            $builder->remove('module')
                ->remove('categorie')
                ->add(
                    'categorie',
                    ChoiceType::class,
                    [
                        'label' => 'Catégorie :',
                        'choices' => [
                            'Support formateur' => 'support_formateur',
                            'Itinéraire pédagogique' => 'itin_pedago',
                            'ECF' => 'ecf',
                            'Modèle' => 'modele'
                        ],
                        'expanded' => true,
                        'multiple' => false


                    ]
                )
                ->add(
                    'titre',
                    TextType::class,
                    [
                        'label' => 'Titre :',
                        'required' => false
                    ]
                );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
            'isAdmin' => false
        ]);
    }
}
