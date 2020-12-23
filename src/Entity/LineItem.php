<?php

namespace App\Entity;

use App\Repository\LineItemRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Core\Annotation\ApiResource;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity; 
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"item:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"item:write"}}
 * )
 * @ORM\Entity(repositoryClass=LineItemRepository::class)
 * @ORM\Table(schema="food", name="line_item")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class LineItem
{
    /**
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"item:read", "item:write", "order:read", "order:write","cart:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="lineItems")
     * @Groups({"item:read", "item:write", "order:read", "order:write","cart:read"})
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"item:read", "item:write", "order:read", "order:write","cart:read"})
     */
    private $quantity;


    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="lineItems")
     * 
     * 
     */
    private $commande;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"item:read", "order:read"})
     */
    private $total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    
    public function getCommande(): ?Order
    {
        return $this->commande;
    }

    public function setCommande(?Order $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

  

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
