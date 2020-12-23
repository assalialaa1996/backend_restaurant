<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Form\AddresseType;

class ClientType extends AbstractType
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
            ->add('Nom',TextType::class,$this->getConfiguration("", "Exemple : LOUSSAMBOULOU"))
            ->add('Prenom',TextType::class,$this->getConfiguration("", "Exemple : Josephat Aimé "))
            ->add('Email',EmailType::class,$this->getConfiguration("", "Exemple : j@gmail.com"))
            ->add('Telephone',TextType::class,$this->getConfiguration("", "Exemple : 06 05 00 00 00"))
            ->add('Mobile',TextType::class,$this->getConfiguration("", "Exemple : 06 05 00 00 00"))
            ->add('genre',TextType::class,$this->getConfiguration("", "Exemple : M"))
            ->add('dateCre',HiddenType::class,["label"=>"Email", 'attr'=>["value"=> "new \DateTime('now')"]])
            ->add('dateUp',HiddenType::class,["label"=>"Email", 'attr'=>["value"=> "new \DateTime('now')"]])
            ->add('MotDePasse',TextType::class,$this->getConfiguration("", "Exemple : ********************"))
            ->add('Roles',HiddenType::class,["label"=>"Email", 'attr'=>["value"=>"ROLE_USER"]])
            ->add('Adresse',AddresseType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
