<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\User;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'label' => 'Prénom*',
                'attr' => ['placeholder' => 'Prénom*'],
                'label' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom',
                    ]),
                ],
            ])
            ->add('lastName', null, [
                'label' => 'Prénom*',
                'attr' => ['placeholder' => 'Nom*'],
                'label' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom',
                    ]),
                ],
            ])
            ->add('address', null, [
                'label' => 'Adresse (numéro et rue)*',
                'attr' => ['placeholder' => 'Adresse (numéro et rue)*'],
                'label' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre adresse (numéro et rue)',
                    ]),
                ],
            ])
            ->add('postalCode', null, [
                'label' => 'Code postal',
                'label' => false,
                'attr' => [
                    'min' => 0,
                    'placeholder' => 'Code postal*',
                ],
                'required' => true,
                'constraints' => [
                    new Positive([
                        'message' => 'Le code postal doit être positif'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner un code postal',
                    ]),
                ],
            ])
            ->add('town', null, [
                'label' => 'Ville',
                'label' => false,
                'attr' => ['placeholder' => 'Ville*'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner la ville',
                    ]),
                ],
            ])
            ->add('phoneNumber', null, [
                'label' => 'Téléphone',
                'label' => false,
                'attr' => ['placeholder' => 'Téléphone* 06.....'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un numéro de téléphone afin de faciliter la livraison de votre produit',
                    ]),
                ],
            ])

            /*
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
