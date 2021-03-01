<?php

namespace App\Form;

use App\Entity\Barman;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyPath;
use Vich\UploaderBundle\Form\Type\VichImageType;


class BarmanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom', TextType::class,[
                'label' => 'Prénom'
            ])
            ->add('email', EmailType::class, [
                'label'=>'E-mail'
            ])
            ->add('password',PasswordType::class, [
                'label'=>'Mot de passe'
            ])
            ->add('imageFile', VichImageType::class, [
                'required'=> false,
                'label'=> 'Image'
            ])
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Barman::class,
        ]);  
    }
}
