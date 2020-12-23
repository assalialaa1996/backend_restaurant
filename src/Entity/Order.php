<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use ApiPlatform\Core\Annotation\ApiProperty;
use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;


/**
 * @ApiResource(
 *     normalizationContext={"groups"={"order:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"order:write"}}, 

 *    collectionOperations={
 *      "get",
 *      "get_orders_byDate"={
 *          "method"="GET",
 *          "path"="/orders_count/{owner_id}",
 *          "controller"=App\Controller\OrdersCountByDateController::class
 *         },
 *     "get_most_orderes"={
 *          "method"="GET",
 *          "path"="/orders_most/{owner_id}",
 *          "controller"=App\Controller\MostOrderedProductsController::class
 *         },
 *      "get_earnings_byDate"={
 *          "method"="GET",
 *          "path"="/earning_count/{owner_id}",
 *          "controller"=App\Controller\EarningCountByDateController::class
 *         },
 *   
 *      "post_commande"={
 *          "method"="POST",
 *          "path"="/orders",
 *          "controller"=App\Controller\orderController::class
 *          },
 *     },
 *     itemOperations={
 *         "get",
 *
 *         "put"={"security"="is_granted('ROLE_OWNER')",  "security_message"="Only owners can edit Order."
 *              ,"denormalization_context"={"groups"={"order:put"}} },
 *         "delete"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Only owners or admin can delete livreurs."}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"client.id": "exact","date","orderType":"exact","status":"exact","livreur.firstName":"partial","livreur.lastName":"partial","restaurant.restaurantOwner.id":"exact"})
 * @ApiFilter(DateFilter::class, properties={"date"})
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(schema="food", name="commande")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Order
{
    /**
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

    //Order status
    const STATUS_ORDERED = 'ORDERED';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_INDELIVERY = 'INDELIVERY';
    const STATUS_DELIVERED = 'DELIVERED';
    //Order type
    const TYPE_DELIVERY = 'DELIVERY';
    const TYPE_TAKE_AWAY = 'TAKE_AWAY';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"order:read", "order:write","spec"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"order:read"})
     */
    private $date;




    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="orders")
     * @Groups({"order:read", "order:write"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, inversedBy="commande", cascade={"all"})
     * @Groups({"order:read"})
     */
    private $paymentInfo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"order:read", "order:write"})
     */
    private $adresseLivraison;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"order:read","order:put"})
     */
    private $datePriseEncharge;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"order:read","order:put"})
     */
    private $dateLivraison;

    /**
     * @ORM\ManyToOne(targetEntity=Livreur::class, inversedBy="orders")
     * @Groups({"order:read", "order:put"})
     */
    private $livreur;

    /**
     * @ORM\Column(type="string", length=50 , options={"default" : "TODO"})
     * @Groups({"order:read","order:put"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"order:read", "order:write"})
     */
    private $orderType;

    /**
     * @ORM\OneToMany(targetEntity=LineItem::class, mappedBy="commande", cascade={"all"})
     * @Groups({"order:read", "order:write"})
     * 
     */
    private $lineItems;


    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="orders")
     * @Groups({"order:read"})
     */
    private $restaurant;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"order:read"})
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"order:read", "order:put"})
     */
    private $rejectedReason;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"order:read", "order:put"})
     */
    private $estimateDeliveryTime;


    public function __construct()
    {

        $this->lineItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id = null): self
    {
        $this->id = $id;
        return $this;
    }
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }




    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPaymentInfo(): ?Payment
    {
        return $this->paymentInfo;
    }

    public function setPaymentInfo(?Payment $paymentInfo): self
    {
        $this->paymentInfo = $paymentInfo;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(?string $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getDatePriseEncharge(): ?\DateTimeInterface
    {
        return $this->datePriseEncharge;
    }

    public function setDatePriseEncharge(?\DateTimeInterface $datePriseEncharge): self
    {
        $this->datePriseEncharge = $datePriseEncharge;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(?\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if (!in_array($status, array(self::STATUS_ACCEPTED, self::STATUS_ORDERED, self::STATUS_REJECTED, self::STATUS_DELIVERED, self::STATUS_INDELIVERY))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
    }

    public function getOrderType(): ?string
    {
        return $this->orderType;
    }

    public function setOrderType(string $orderType): self
    {
        /* if (!in_array($orderType, array(self::TYPE_DELIVERY, self::TYPE_TAKE_AWAY))) {
            throw new \InvalidArgumentException("Invalid type");
        }*/

        $this->orderType = $orderType;

        return $this;
    }

    /**
     * @return Collection|LineItem[]
     */
    public function getLineItems(): Collection
    {
        return $this->lineItems;
    }

    public function addLineItem(LineItem $lineItem): self
    {
        if (!$this->lineItems->contains($lineItem)) {
            $this->lineItems[] = $lineItem;
            $lineItem->setCommande($this);
        }

        return $this;
    }

    public function setLineItems(array $lineItems)
    {
        $this->lineItems = new ArrayCollection();
        foreach ($lineItems as $lineItem) {
            $this->addLineItem($lineItem);
        }
        return $this;
    }

    public function removeLineItem(LineItem $lineItem): self
    {
        if ($this->lineItems->contains($lineItem)) {
            $this->lineItems->removeElement($lineItem);
            // set the owning side to null (unless already changed)
            if ($lineItem->getCommande() === $this) {
                $lineItem->setCommande(null);
            }
        }

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getRejectedReason(): ?string
    {
        return $this->rejectedReason;
    }

    public function setRejectedReason(?string $rejectedReason): self
    {
        $this->rejectedReason = $rejectedReason;

        return $this;
    }

    public function getEstimateDeliveryTime(): ?\DateTimeInterface
    {
        return $this->estimateDeliveryTime;
    }

    public function setEstimateDeliveryTime(?\DateTimeInterface $estimateDeliveryTime): self
    {
        $this->estimateDeliveryTime = $estimateDeliveryTime;

        return $this;
    }
}
