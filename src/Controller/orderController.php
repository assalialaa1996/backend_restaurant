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
use App\Entity\Product;

class orderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**

     * 
     */
    public function __invoke(Request $request)
    {
        $content = $request->getContent();
        $data = $this->get('serializer')->deserialize($content, 'App\Entity\Order', 'json');


        // TODO: Implement persist() method.


        $restaurantOrders  = [];
        $temp = new Order();
        foreach ($data->getLineItems() as $item) {
            $restaurantId = $item
                ->getProduct()
                ->getMenu()
                ->getRestaurant()
                ->getId();
            if ($item->getQuantity() > $item->getProduct()->getStock()) {
                return ["outstock" => $item->getProduct()];
            };

            $item->setTotal($item->getProduct()->getunitPrice() * $item->getQuantity());

            if (!array_key_exists($restaurantId, $restaurantOrders)) {
                $restaurantOrders[$restaurantId] = [$item];
            } else {
                $restaurantOrders[$restaurantId][] = $item;
            }
            $temp->addLineItem($item);
            $data->removeLineItem($item);
        }
        foreach ($temp->getLineItems() as $item) {
            $product = $this->entityManager->getRepository(Product::class)->find($item->getProduct()->getId());
            $product->setStock($product->getStock() - $item->getQuantity());
            $this->entityManager->flush();
        }



        // create new order by restaurantOrderItem according to product from restaurant menu
        //$tab=[];
        foreach ($restaurantOrders as $key => $restaurantOrderItems) {
            unset($newData);
            $newData = new Order();
            $newData = clone $data;
            $total = 0;
            foreach ($restaurantOrderItems as  $val) {
                # code...
                $newData->addLineItem($val);
                $total += $val->getProduct()->getUnitPrice() * $val->getQuantity();
            }
            $newData->setTotalPrice($total);
            $newData->setDate(new DateTime());
            $restaurant = $this->entityManager->getRepository(Restaurant::class)->find($key);
            $newData->setRestaurant($restaurant);
            $newData->setStatus('ORDERED');
            $this->entityManager->persist($newData);
        }
        $this->entityManager->flush();

        return new Response('Order Passed', Response::HTTP_CREATED);
    }
}
