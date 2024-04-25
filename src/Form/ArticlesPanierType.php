<?php

namespace App\Form;

use App\Entity\ArticlesPanier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ArticlesPanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class , [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une quantité',
                    ]),
                    new Positive([
                        'message' => 'Veuillez renseigner une quantité positive'
                    ])
                ],
            ])
            /*
            ->add('panier', EntityType::class, [
                'class' => Panier::class,
                'choice_label' => 'id',
            ])
            ->add('commande', EntityType::class, [
                'class' => Commande::class,
                'choice_label' => 'id',
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticlesPanier::class,
        ]);
    }
}
