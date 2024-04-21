<?php

namespace App\Form;

use App\Entity\ArticlesPanier;
use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesPanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'id',
            ])
            ->add('panier', EntityType::class, [
                'class' => Panier::class,
                'choice_label' => 'id',
            ])
            ->add('commande', EntityType::class, [
                'class' => Commande::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticlesPanier::class,
        ]);
    }
}
