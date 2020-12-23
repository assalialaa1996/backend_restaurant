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


class ReservCountByDateController extends AbstractController
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
        $status_ok = 'RESERVED';
        $query =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, MONTH(res.date) AS Month, COUNT(res) AS total
            FROM App\Entity\Reservation res
            INNER JOIN res.restaurant r
            WHERE res.status= :statusOK AND r.id=:restaurant
           
            GROUP BY Year,Month
            ORDER BY MONTH(res.date) ASC'
        )->setParameter('statusOK', $status_ok)
            ->setParameter('restaurant', $restID);
        $query2 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, MONTH(res.date) AS Month, DAY(res.date) AS Day, COUNT(res) AS total
            FROM App\Entity\Reservation res
            INNER JOIN res.restaurant r
            WHERE res.status= :statusOK AND r.id=:restaurant
           
            GROUP BY Year,Month,Day
            ORDER BY Year(res.date) ASC'
        )->setParameter('statusOK', $status_ok)
            ->setParameter('restaurant', $restID);
        $query3 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, WEEK(res.date) AS Week, COUNT(res) AS total
            FROM App\Entity\Reservation res
            INNER JOIN res.restaurant r
            WHERE res.status= :statusOK AND r.id=:restaurant
            GROUP BY Year,Week
            ORDER BY Year(res.date) ASC'
        )->setParameter('statusOK', $status_ok)
            ->setParameter('restaurant', $restID);


        $status_NO = 'CANCELED';
        $query4 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, MONTH(res.date) AS Month, COUNT(res) AS total
            FROM App\Entity\Reservation res
            INNER JOIN res.restaurant r
            WHERE res.status= :statusNO AND r.id=:restaurant
           
            GROUP BY Year,Month
            ORDER BY MONTH(res.date) ASC'
        )->setParameter('statusNO', $status_NO)
            ->setParameter('restaurant', $restID);
        $query5 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, MONTH(res.date) AS Month, DAY(res.date) AS Day, COUNT(res) AS total
            FROM App\Entity\Reservation res
            INNER JOIN res.restaurant r
            WHERE res.status= :statusNO AND r.id=:restaurant
           
            GROUP BY Year,Month,Day
            ORDER BY Year(res.date) ASC'
        )->setParameter('statusNO', $status_NO)
            ->setParameter('restaurant', $restID);
        $query6 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, WEEK(res.date) AS Week, COUNT(res) AS total
            FROM App\Entity\Reservation res
            INNER JOIN res.restaurant r
            WHERE res.status= :statusNO AND r.id=:restaurant
            GROUP BY Year,Week
            ORDER BY Year(res.date) ASC'
        )->setParameter('statusNO', $status_NO)
            ->setParameter('restaurant', $restID);

        $query7 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, WEEK(res.date) AS Week, COUNT(res) AS total
                FROM App\Entity\Reservation res
                INNER JOIN res.restaurant r
                WHERE  r.id=:restaurant
                GROUP BY Year,Week
                ORDER BY Year(res.date) ASC'
        )
            ->setParameter('restaurant', $restID);
        $query8 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, MONTH(res.date) AS Month,DAY(res.date) AS Day, COUNT(res) AS total
                    FROM App\Entity\Reservation res
                    INNER JOIN res.restaurant r
                    WHERE  r.id=:restaurant
                    GROUP BY Year,Month,Day
                    ORDER BY Year(res.date) ASC'
        )
            ->setParameter('restaurant', $restID);
        $query9 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, MONTH(res.date) AS Month, COUNT(res) AS total
                    FROM App\Entity\Reservation res
                    INNER JOIN res.restaurant r
                    WHERE  r.id=:restaurant
                    GROUP BY Year,Month
                    ORDER BY Year(res.date) ASC'
        )
            ->setParameter('restaurant', $restID);

        $query10 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, COUNT(res) AS total
                FROM App\Entity\Reservation res
                INNER JOIN res.restaurant r
                WHERE res.status= :statusNO AND r.id=:restaurant
                GROUP BY Year
                ORDER BY Year(res.date) ASC'
        )->setParameter('statusNO', $status_NO)
            ->setParameter('restaurant', $restID);
        $query11 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year,  COUNT(res) AS total
                FROM App\Entity\Reservation res
                INNER JOIN res.restaurant r
                WHERE res.status= :statusOK AND r.id=:restaurant
                GROUP BY Year
                ORDER BY Year(res.date) ASC'
        )->setParameter('statusOK', $status_ok)
            ->setParameter('restaurant', $restID);

        $query12 =  $this->entityManager->createQuery(
            'SELECT YEAR(res.date) AS Year, COUNT(res) AS total
                        FROM App\Entity\Reservation res
                        INNER JOIN res.restaurant r
                        WHERE  r.id=:restaurant
                        GROUP BY Year
                        ORDER BY Year(res.date) ASC'
        )
            ->setParameter('restaurant', $restID);

        $countByYear = $query12->getResult();
        $countByMonth = $query9->getResult();
        $countByDay = $query8->getResult();
        $countByWeek = $query7->getResult();

        $countByMonth_reserved = $query->getResult();
        $countByDay_reserved = $query2->getResult();
        $countByWeek_reserved = $query3->getResult();
        $countByYear_reserved = $query11->getResult();

        $countByYear_canceled = $query10->getResult();
        $countByMonth_canceled = $query4->getResult();
        $countByDay_canceled = $query5->getResult();
        $countByWeek_canceled = $query6->getResult();

        return ["ALL" => ["YEAR"=> $countByYear,"MONYH-YEAR" => $countByMonth, "DAY-MONTH" => $countByDay, "WEEK-YEAR" => $countByWeek], "RESERVED" => ["YEAR"=>$countByYear_reserved, "MONYH-YEAR" => $countByMonth_reserved, "DAY-MONTH" => $countByDay_reserved, "WEEK-YEAR" => $countByWeek_reserved], "CANCELED" => ["YEAR"=>$countByYear_canceled, "MONYH-YEAR" => $countByMonth_canceled, "DAY-MONTH" => $countByDay_canceled, "WEEK-YEAR" => $countByWeek_canceled]];
    }
}
