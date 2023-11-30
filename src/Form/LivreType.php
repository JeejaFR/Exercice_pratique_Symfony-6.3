<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre: ',
                'required' => true,
                'attr' => [
                    'placeholder' => "Titre du livre.."
                ] 
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'multiple' => true,
            ])
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'required' => true,
                'choice_label' => function ($auteur) {
                    return $auteur->getNom() . ' ' . $auteur->getPrenom();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
