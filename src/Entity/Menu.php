<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity; 
use ApiPlatform\Core\Annotation\ApiProperty;
/**
 * @ApiResource( 
 *     normalizationContext={"groups"={"menu:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"menu:write"},"enable_max_depth"=true},
 *     collectionOperations={
 *          "get",
 *          "post"={ "security_message"="Only Owners can add menus."},
 *          
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('ROLE_OWNER') and object.getRestaurant().getRestaurantOwner() == user or is_granted('ROLE_ADMIN')", "security_message"="Only owners or admin can edit menus."},
 *         "delete"={"security"="is_granted('ROLE_OWNER') and object.getRestaurant().getRestaurantOwner() == user or is_granted('ROLE_ADMIN')", "security_message"="Only owners or admin can delete menus."}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"restaurant.restaurantOwner.id": "exact","label":"exact"})
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 * @ORM\Table(schema="food", name="menu")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Menu
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
     * @Groups({"menu:read", "menu:write", "product:read", "order:read"})
     */
    private $id;

   

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"menu:read", "menu:write",  "product:read" , "order:read"})
     */
    private $label;

 

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="menu")
     * @Groups({"menu:read"})
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="menus")
     * @Groups({"menu:read","menu:write"})
     */
    private $restaurant;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

 
    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

 
  

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setMenu($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getMenu() === $this) {
                $product->setMenu(null);
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



  
}
