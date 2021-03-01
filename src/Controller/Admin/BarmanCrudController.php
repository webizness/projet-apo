<?php

namespace App\Controller\Admin;

use App\Entity\Barman;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;





class BarmanCrudController extends AbstractCrudController
{
    
     /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            IdField::new('id')->onlyOnIndex(),
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('email'),
            TextField::new('plainPassword','mot de passe' )->onlyOnForms(),
            TextField::new('image'),
            ChoiceField::new('proprietaire')
                ->setChoices([
                'Propriétaire' =>'ROLE_BARMAN',
                'Barman'=>'ROLE_USER',
            ]),
            //DateTimeField::new('createdAt'),
            //DateTimeField::new('updatedAt'),
            AssociationField::new('bar'),
        ];
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
       
            $encodedPassword = $this->passwordEncoder->encodePassword($entityInstance, $entityInstance->getPlainPassword());
            $entityInstance->setPassword($encodedPassword);
            parent::persistEntity($entityManager, $entityInstance);
        
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if($entityInstance->getPlainPassword()){
            $encodedPassword = $this->passwordEncoder->encodePassword($entityInstance, $entityInstance->getPlainPassword());
            $entityInstance->setPassword($encodedPassword);
        }
        parent::updateEntity($entityManager,$entityInstance);
    }



    public static function getEntityFqcn(): string
    {
        return Barman::class;
    }
    

}