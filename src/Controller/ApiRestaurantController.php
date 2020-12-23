<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\RestaurantRepository;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class ApiRestaurantController extends AbstractController
{
    /**
     * @Route("/api/restaurant", name="api_restaurant")
     */
    public function index()
    {
        return $this->render('api_restaurant/index.html.twig', [
            'controller_name' => 'ApiRestaurantController',
        ]);
    }
 
}
