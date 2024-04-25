<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le nom du produit',
                    ])
            ]
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une description',
                    ])
            ]])
            ->add('prix', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un prix',
                    ]),
                    new Positive([
                        'message' => 'Veuillez renseigner une valeur positive',
                    ])
            ]])
            ->add('stockQuantite', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner la quantité de stock',
                    ]),
                    new Positive([
                        'message' => 'Veuillez renseigner une valeur positive',
                    ])
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
