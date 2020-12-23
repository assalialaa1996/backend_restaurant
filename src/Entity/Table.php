<?php

namespace App\Entity;

use App\Repository\TableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity; 
/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TableRepository::class)
 * @ORM\Table(schema="food",name="tabl")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Table
{
    /**
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

        //Reservation status
        const RESERVED = 'RESERVED';
        const NOT_RESERVED = 'NOT_RESERVED';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"reservation:read","restaurant:read"})
     */
    private $id;



    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="tabl")
     */
    private $reservations;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"reservation:read","restaurant:read"})
     */
    private $chairNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="tables")
     * @Groups({"reservation:read"})
     */
    private $restaurant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : "NOT_RESERVED"})
     * @Groups({"reservation:read","restaurant:read"})
     */
    private $status;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

 


    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setTabl($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getTabl() === $this) {
                $reservation->setTabl(null);
            }
        }

        return $this;
    }

    public function getChairNumber(): ?int
    {
        return $this->chairNumber;
    }

    public function setChairNumber(int $chairNumber): self
    {
        $this->chairNumber = $chairNumber;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        if (!in_array($status, array(self::RESERVED, self::NOT_RESERVED))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;

        return $this;
    }
}
