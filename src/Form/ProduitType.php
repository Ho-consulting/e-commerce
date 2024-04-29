<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image du produit',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
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
            ->add('specifite1', TextType::class)
            ->add('specefite2', TextType::class)
            ->add('specefite3', TextType::class)
            ->add('specifite4', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
