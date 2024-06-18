<?php

namespace App\Form;

use App\Entity\site;
use DateTimeImmutable;
use App\Entity\Formation;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'intitule',
                TextType::class,
                [
                    'label' => 'Intitulé :',
                    'required' => false
                ]
            )

            ->add(
                'date_debut',
                TextType::class,
                [
                    'label' => 'Date de début :',
                    'required' => false
                ]
            )

            ->add(
                'date_fin',
                TextType::class,
                [
                    'label' => 'Date de fin :',
                    'required' => false
                ]
            )

            ->add('site', EntityType::class, [
                'class' => site::class,
                'choice_label' =>  function (Site $Site): string {
                    return $Site->getVille();
                },
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.ville', 'ASC');
                },
                'expanded' => false,
                'multiple' => false,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
            'sanitize_html' => true
        ]);
    }
}
