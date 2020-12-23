<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"product:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"product:write"}}, 
 *     collectionOperations={
 *          "get",
 *          "post"={"security_message"="Only Owners can add products."},
 *          
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('ROLE_OWNER') and object.getMenu().getRestaurant().getRestaurantOwner() == user or is_granted('ROLE_ADMIN')", "security_message"="Only owners or admin can edit products."},
 *         "delete"={"security"="is_granted('ROLE_OWNER') and object.getMenu().getRestaurant().getRestaurantOwner() == user or is_granted('ROLE_ADMIN')", "security_message"="Only owners or admin can delete products."}
 *     }
 * )
 * 
 * @ApiFilter(SearchFilter::class, properties={"menu.restaurant.restaurantOwner.id": "exact","name":"exact","menu.id":"exact"})
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(schema="food", name="product")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Product
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
     * @Groups({"product:read", "product:write", "menu:read", "menu:write","order:read", "item:read","cart:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read", "product:write", "menu:read", "menu:write","order:read", "item:read","cart:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read", "product:write", "menu:read", "menu:write", "order:read", "item:read","cart:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Groups({"product:read", "product:write", "menu:read", "menu:write", "order:read", "item:read","cart:read"})
     */
    private $unitPrice;

    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="products")
     * @Groups({"product:read", "product:write", "order:read", "cart:read"})
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity=LineItem::class, mappedBy="product")
     */
    private $lineItems;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"product:read", "product:write", "menu:read", "menu:write", "order:read", "item:read","cart:read"})
     */
    public $image;

    /**
     * @ORM\Column(type="integer" , nullable=true)
     * @Groups({"product:read", "product:write", "menu:read", "menu:write","cart:read"})
     */
    private $stock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"product:read", "product:write", "menu:read", "menu:write","cart:read"})
     */
    private $seuil;


    public function __construct()
    {
        $this->lineItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

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
            $lineItem->setProduct($this);
        }

        return $this;
    }

    public function removeLineItem(LineItem $lineItem): self
    {
        if ($this->lineItems->contains($lineItem)) {
            $this->lineItems->removeElement($lineItem);
            // set the owning side to null (unless already changed)
            if ($lineItem->getProduct() === $this) {
                $lineItem->setProduct(null);
            }
        }

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getSeuil(): ?int
    {
        return $this->seuil;
    }

    public function setSeuil(?int $seuil): self
    {
        $this->seuil = $seuil;

        return $this;
    }


}
