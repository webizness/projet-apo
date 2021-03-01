<?php

namespace App\Form;

use App\Entity\Bar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('horaire')
            ->add('email', EmailType::class, [
                'label'=>'E-mail'
            ])
            ->add('telephone', TextType::class,[
                'label' => 'Téléphone'
            ])
            ->add('adresse')
            ->add('ville')
            ->add('code_postal')
            ->add('rcs')
            ->add('image', TextType::class, [
                'label'=>'Image'
            ])
            //->add('createdAt')
            //->add('updatedAt')
            //->add('produits')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bar::class,
        ]);
    }
}
