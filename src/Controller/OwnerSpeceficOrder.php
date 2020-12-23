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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class OwnerSpeceficOrder extends AbstractController
{
  protected $em;


  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }



  public function __invoke(Request $request)
  {
    $owner_id = $request->attributes->get('owner_id');
    $order_id = $request->attributes->get('order_id');


    $order = $this->em->getRepository(Order::class)->find($order_id);




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
        $lineItems->removeElement($lineItem);
      }
    }

    if (count($order->getLineItems()) > 0) {
      $total = 0;
      foreach ($order->getLineItems() as $item) {
        $total += $item->getPrice() * $item->getQuantity();
        $a[] = $item;
      }

      $order->total = $total;
      $order->Owneritems = $a;


      $data =  $this->get('serializer')->serialize($order, 'json');

      $response = new Response($data);
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    }
  }

  /*
        $order=$this->em->getRepository(Order::class)->find($order_id);

        $lineItems=$order->getLineItems();
        
        foreach ($lineItems as $lineItem) {
        # code...
        if ($lineItem->getProduct()
                    ->getMenu()
                   
                    ->getRestaurant()
                    ->getRestaurantOwner()
                    ->getId() != $owner_id) 
                  {
                      $order->removeLineItem($lineItem);
                  }
        }
        //
        if( count($order->getLineItems())>0){
          $total=0;
          foreach($order->getLineItems() as $item)
          {
              $total +=$item->getPrice()*$item->getQuantity();
          }
          $order->total=$total;
          return $order;
        }else{
            return null;
        }*/
}
