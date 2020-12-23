<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\LineItem;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Collection\CollectionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OwnerSpeceficOrders extends AbstractController
{
  protected $em;


  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }



  public function __invoke(Request $request)
  {
    $owner_id = $request->attributes->get('owner_id');
    $orders = $this->em->getRepository(Order::class)->findAll();

    $ownerOrders = new ArrayCollection();
    foreach ($orders as $order) {
      # code...
      $lineItems = new ArrayCollection();

      $lineItems = $order->getLineItems();


      foreach ($lineItems as $lineItem) {
        # code...
        if ($lineItem->getProduct()
          ->getMenu()

          ->getRestaurant()
          ->getRestaurantOwner()
          ->getId() != $owner_id
        ) {
          $order->removeLineItem($lineItem);
        }
      }
      if (count($order->getLineItems()) > 0) {
        $total = 0;
        foreach ($order->getLineItems() as $item) {
          $total += $item->getPrice() * $item->getQuantity();
        }

        $order->total = $total;

        $ownerOrders->add($order);
      }
    }

    return $ownerOrders;
  }
}
