<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"owner:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"owner:write"},"enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantOwnerRepository")
 * @ORM\Table(schema="food", name="restaurantowner")
 */
class RestaurantOwner extends Account
{
    /**
     * @ORM\Id()
     * ORM\OneToOne(targetEntity=Account::class, cascade={"persist", "remove"})
     * @Groups({"owner:read"})
     * 
     **/
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity=Restaurant::class, inversedBy="restaurantOwner", cascade={"persist", "remove"})
     */
    private $restaurant;

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles = array('ROLE_OWNER');

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
