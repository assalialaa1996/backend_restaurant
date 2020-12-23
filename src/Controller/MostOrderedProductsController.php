<?php

namespace App\Controller;

//…

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Restaurant;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RestaurantOwner;
use phpDocumentor\Reflection\Types\Integer;

class MostOrderedProductsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $emConfig = $this->entityManager->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Postgresql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Postgresql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Postgresql\Day');
        $emConfig->addCustomDatetimeFunction('WEEK', 'Gesdinet\DQL\Datetime\Week');
    }


    public function __invoke(Request $request)
    {
        $owner_id = $request->attributes->get('owner_id');
        $restaurantOwner = $this->entityManager->getRepository(RestaurantOwner::class)->find($owner_id);
        $restID = $restaurantOwner->getRestaurant()->getId();

        $query =  $this->entityManager->createQuery(
            'SELECT COUNT (l.product ) AS count, p.id AS prod
            FROM App\Entity\LineItem l
            INNER JOIN l.product p
            INNER JOIN p.menu m
            INNER JOIN m.restaurant r
            WHERE r.id=:restaurant
            GROUP BY l.product,p.id
            ORDER BY count DESC'
        )->setParameter('restaurant', $restID);
        $count = $query->getResult();
        $result=null;
        foreach ($count as $value) {
          
            $product = $this->entityManager->getRepository(Product::class)->find( $value["prod"] );
            $value["prod"] = $product;
            $result[]= $value;
        }
      
        return $result;
    }
}
