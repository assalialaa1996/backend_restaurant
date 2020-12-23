<?php

namespace App\Controller;

//…

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Entity\Restaurant;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\RestaurantOwner;

class OrdersCountByDateController extends AbstractController
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
            'SELECT YEAR(o.date) AS Year, MONTH(o.date) AS Month, count(o) AS total
            FROM App\Entity\Order o
            INNER JOIN o.restaurant r
            WHERE r.id=:restaurant
            GROUP BY Year,Month
            ORDER BY MONTH(o.date) ASC'
        )->setParameter('restaurant', $restID);
        $query2 =  $this->entityManager->createQuery(
            'SELECT YEAR(o.date) AS Year, MONTH(o.date) AS Month, DAY(o.date) AS Day, count(o) AS total
            FROM App\Entity\Order o
            INNER JOIN o.restaurant r
            WHERE r.id=:restaurant
            GROUP BY Year,Month,Day
            ORDER BY Year(o.date) ASC'
        )->setParameter('restaurant', $restID);
        $query3 =  $this->entityManager->createQuery(
            'SELECT YEAR(o.date) AS Year, WEEK(o.date) AS Week, count(o) AS total
            FROM App\Entity\Order o
            INNER JOIN o.restaurant r
            WHERE r.id=:restaurant
            GROUP BY Year,Week
            ORDER BY Year(o.date) ASC'
        )->setParameter('restaurant', $restID);
        $status_ok = 'DELIVERED';
        $query4 = $this->entityManager->createQuery(

            'SELECT  count(o) 
            FROM App\Entity\Order o
            INNER JOIN o.restaurant r
        
            WHERE o.status= :statusOK AND  r.id=:restaurant'
        )->setParameter('statusOK', $status_ok)
            ->setParameter('restaurant', $restID);

        $status_No = 'REJECTED';
        $query5 = $this->entityManager->createQuery(

            'SELECT  count(o) 
            FROM App\Entity\Order o
            INNER JOIN o.restaurant r
            WHERE o.status = :statusNO AND  r.id=:restaurant'
        )->setParameter('statusNO', $status_No)
            ->setParameter('restaurant', $restID);


        $countByMonth = $query->getResult();
        $countByDay = $query2->getResult();
        $countByWeek = $query3->getResult();
        $totalDelivered = $query4->getResult()[0];
        $totalRejected = $query5->getResult()[0];
        return [
            "MONYH-YEAR" => $countByMonth,
            "DAY-MONTH" => $countByDay,
            "WEEK-YEAR" => $countByWeek,
            "totalDelivered" => $totalDelivered[1],
            "totalRejected" =>  $totalRejected[1]
        ];
    }
}
