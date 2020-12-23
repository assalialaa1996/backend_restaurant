<?php

namespace App\Controller;

use App\Entity\Speciality;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class SpecialityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Speciality::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $specialite = new Speciality();

        return $specialite;
    }

    
    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
        // this defines the pagination size for all CRUD controllers
        // (each CRUD controller can override this value if needed)
        ->setPaginatorPageSize(5);
    }


}
