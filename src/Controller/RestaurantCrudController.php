<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use Symfony\Component\Routing\Annotation\Route;

use JMS\Serializer\SerializationContext;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class RestaurantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Restaurant::class;
    }
    
    public function createEntity(string $entityFqcn)
    {
        $restaurant = new Restaurant();

        return $restaurant;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return Crud::new()
        // this defines the pagination size for all CRUD controllers
        // (each CRUD controller can override this value if needed)
        ->setPaginatorPageSize(5);
    }

   /* public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('name'),
            Field::new('minPrice'),
            Field::new('dureeLivraison'),
            Field::new('logo'),

        ];
    }*/

}
