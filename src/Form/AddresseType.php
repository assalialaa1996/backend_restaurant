<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AddresseType extends AbstractType
{

    private function getConfiguration($titre, $place){
        return [
                "label"=>$titre, 'attr'=>[
                    "placeholder"=>$place,
                     "class"=>"form-control"
                ]
            ];
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Numero',TextType::class,$this->getConfiguration("", "Exemple : LOUSSAMBOULOU"))
            ->add('Rue',TextType::class,$this->getConfiguration("", "Exemple : Josephat Aimé "))
            ->add('CodePostal',textType::class,$this->getConfiguration("", "Exemple : j@gmail.com"))
            ->add('Ville',TextType::class,$this->getConfiguration("", "Exemple : 06 05 00 00 00"))
            ->add('State',TextType::class,$this->getConfiguration("", "Exemple : 06 05 00 00 00"))
            ->add('Pays',textType::class,$this->getConfiguration("", "Exemple : M"))
            ->add('Latitude',textType::class,$this->getConfiguration("", "Exemple : M"))
            ->add('longitude',textType::class,$this->getConfiguration("", "Exemple : M"));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
