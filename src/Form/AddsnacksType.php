<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AddsnacksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('imageFile', VichImageType::class, [
                'required'=> false,
                'label'=>'Image'
            ])
            ->add('prix')
            ->add('description')
            ->add('ingredient', TextType::class,[
                'label' => 'Ingrédient(s)'
            ])
            ->add('quantite', TextType::class,[
                'label' => 'Quantité'
            ])
            ->add('createdAt')
            //->add('updatedAt')
           // ->add('categories')
            //->add('bars')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
