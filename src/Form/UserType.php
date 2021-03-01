<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label'=>'E-mail'
            ])
            ->add('nom')
            ->add('prenom', TextType::class, [
                'label'=>'Prénom'
            ])
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->add('telephone', TextType::class, [
                'label'=>'Téléphone'
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, [$this,'onPreSetData'])
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this,'onsubmitData'])
        ;
    }

    public function onPreSetData(FormEvent $event){
        dump($event->getData());
    }
    public function onsubmitData(FormEvent $event){
        dump($event->getData());
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
