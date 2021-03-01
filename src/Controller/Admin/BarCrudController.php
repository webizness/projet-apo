<?php

namespace App\Controller\Admin;

use App\Entity\Bar;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\HttpFoundation\File\File;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;


class BarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bar::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField ::new('image')
            ->setUploadDir("public/image/bar")
            ->setBasePath("image/bar")
            ->setFormType(FileUploadType::class),
            TextField::new('nom'),
            IntegerField::new('horaire'),
            TextField::new('email'),
            IntegerField::new('telephone'),
            TextField::new('adresse'),
            TextField::new('ville'),
            TextField::new('code_postal'),
            TextField::new('rcs'),
            
         
            //ImageField ::new('imageFile')
            //->setFormType(VichImageType::class)
            //->onlyOnForms()
            //->setUploadDir("public/image/bar"),
        
           
        ];
    }
    
}
