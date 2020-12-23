<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Entity\RestaurantOwner;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repoClients = $em->getRepository(Client::class);
        $counts = $repoClients->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $repoResto = $em->getRepository(RestaurantOwner::class);
        $countResto = $repoResto->createQueryBuilder('r')
            ->select('count(r.id)')
            ->getQuery()
            ->getSingleScalarResult();
        //dd($counts);
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'nb' => $counts,
            'nbs' => $countResto,
        ]);
    }
}
