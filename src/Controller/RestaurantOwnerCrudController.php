<?php

namespace App\Controller;

use App\Entity\RestaurantOwner;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RestaurantOwnerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RestaurantOwner::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $restauOwner = new RestaurantOwner();

        return $restauOwner;
    }
}
