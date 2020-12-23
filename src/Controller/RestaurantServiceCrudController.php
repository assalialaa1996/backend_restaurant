<?php

namespace App\Controller;

use App\Entity\RestaurantService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class RestaurantServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RestaurantService::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $service = new RestaurantService();

        return $service;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
        // this defines the pagination size for all CRUD controllers
        // (each CRUD controller can override this value if needed)
        ->setPaginatorPageSize(5);
    }
}
