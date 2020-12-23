<?php

namespace App\Entity;

use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity; 
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"livreur:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"livreur:write"},"enable_max_depth"=true},
 *    collectionOperations={
 *          "get",
 *          "post"={ "security_message"="Only Owners can add livreurs."},
 *          
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('ROLE_OWNER') and object.getRestaurant().getRestaurantOwner() == user or is_granted('ROLE_ADMIN')", "security_message"="Only owners or admin can edit livreurs."},
 *         "delete"={"security"="is_granted('ROLE_OWNER') and object.getRestaurant().getRestaurantOwner() == user or is_granted('ROLE_ADMIN')", "security_message"="Only owners or admin can delete livreurs."}
 *     })
 * @ApiFilter(SearchFilter::class, properties={"restaurant.restaurantOwner.id": "exact"})
 * @ORM\Entity(repositoryClass=LivreurRepository::class)
 * @ORM\Table(schema="food", name="livreur")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Livreur
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
     * @Groups({"order:read","livreur:read","livreur:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"order:read","livreur:read","livreur:write"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"order:read","livreur:read","livreur:write"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"order:read","livreur:read","livreur:write"})
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="livreur")
     * 
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="livreurs")
     * @Groups({"livreur:write"})
     */
    private $restaurant;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setLivreur($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getLivreur() === $this) {
                $order->setLivreur(null);
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
