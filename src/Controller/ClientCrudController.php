<?php

namespace App\Controller;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $client = new Client();

        return $client;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
        // this defines the pagination size for all CRUD controllers
        // (each CRUD controller can override this value if needed)
        ->setPaginatorPageSize(5);
    }

    /*public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('firstName'),
            Field::new('lastName'),
            Field::new('email'),
            Field::new('address'),

        ];
    }*/
}
