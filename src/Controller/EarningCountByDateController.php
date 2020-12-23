<?php

namespace App\Controller;

//…

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Entity\Restaurant;
use App\Entity\RestaurantOwner;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;


class EarningCountByDateController extends AbstractController
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

    /**

     * 
     */
    public function __invoke(Request $request)
    {
        $owner_id = $request->attributes->get('owner_id');
        $restaurantOwner = $this->entityManager->getRepository(RestaurantOwner::class)->find($owner_id);
        $restID = $restaurantOwner->getRestaurant()->getId();
        $status_ok = 'DELIVERED';
        $query =  $this->entityManager->createQuery(
            'SELECT YEAR(o.date) AS Year, MONTH(o.date) AS Month, SUM(o.totalPrice) AS total
            FROM App\Entity\Order o
            INNER JOIN o.restaurant r
            WHERE o.status= :statusOK AND r.id=:restaurant
           
            GROUP BY Year,Month
            ORDER BY MONTH(o.date) ASC'
        )->setParameter('statusOK', $status_ok)
            ->setParameter('restaurant', $restID);
        $query2 =  $this->entityManager->createQuery(
            'SELECT YEAR(o.date) AS Year, MONTH(o.date) AS Month, DAY(o.date) AS Day, SUM(o.totalPrice) AS total
            FROM App\Entity\Order o
            INNER JOIN o.restaurant r
            WHERE o.status= :statusOK AND r.id=:restaurant
            GROUP BY Year,Month,Day
            ORDER BY Year(o.date) ASC'
        )->setParameter('statusOK', $status_ok)
            ->setParameter('restaurant', $restID);
        $query3 =  $this->entityManager->createQuery(
            'SELECT YEAR(o.date) AS Year, WEEK(o.date) AS Week, SUM(o.totalPrice) AS total
            FROM App\Entity\Order o
            INNER JOIN o.restaurant r
            WHERE o.status= :statusOK AND r.id=:restaurant
            GROUP BY Year,Week
            ORDER BY Year(o.date) ASC'
        )->setParameter('statusOK', $status_ok)
            ->setParameter('restaurant', $restID);



        $countByMonth = $query->getResult();
        $countByDay = $query2->getResult();
        $countByWeek = $query3->getResult();

        return ["MONYH-YEAR" => $countByMonth, "DAY-MONTH" => $countByDay, "WEEK-YEAR" => $countByWeek];
    }
}
