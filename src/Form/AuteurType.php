<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom de famille"
                ] 
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Prénom"
                ] 
            ])
            ->add('age', IntegerType::class, [
                'label' => "Âge: ",
                'required' => false,
                'attr' => [
                    'placeholder' => "Âge de l'auteur"
                ]
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Pays d'origine"
                ] 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
