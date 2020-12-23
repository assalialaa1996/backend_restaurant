<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"reservation:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"reservation:write"}}, 
 *     collectionOperations={
 *          "get",
 *          "get_resev_byDate"={
 *              "method"="GET",
 *              "path"="/reserv_count/{owner_id}",
 *              "controller"=App\Controller\ReservCountByDateController::class
 *         },
 *          "post"={"security_message"="Only clients can add reservations."},
 *          
 *     },
 *     itemOperations={
 *         "get"={"security_message"="Only owners or clients or admin can get their reservations info ."},
 *         "put"={  "security_message"="Only Owner can edit Reseravtion.",
 *                  "denormalization_context"={"groups"={"reservation:put"}} },
 *         "delete"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Only owners or admin can delete Reseravtion."}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"client.id": "exact","status": "exact","tabl.restaurant.restaurantOwner.id":"exact"})
 * @ApiFilter(DateFilter::class, properties={"date"})
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 * @ORM\Table(schema="food", name="reservation")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Reservation
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
     * @Groups({"reservation:read", "reservation:write"})
     */
    private $id;



    /**
     * @ORM\Column(type="integer")
     * @Groups({"reservation:read", "reservation:write"})
     */
    private $nbPersonnes;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="reservations")
     * @Groups({"reservation:read", "reservation:write"})
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Table::class, inversedBy="reservations")
     * @Groups({"reservation:read", "reservation:write"})
     */
    private $tabl;

    /**
     * @ORM\Column(type="string", length=255, options={"default":"PENDING"})
     * @Groups({"reservation:read","reservation:put"})
     */
    private $status="PENDING";

    /**
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"reservation:read","reservation:put"})
     */
    private $confirmationDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"reservation:read", "reservation:write"})
     */
    private $note;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"reservation:read","reservation:put"})
     */
    private $cancelDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"reservation:read"})
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

  

    public function getNbPersonnes(): ?int
    {
        return $this->nbPersonnes;
    }

    public function setNbPersonnes(int $nbPersonnes): self
    {
        $this->nbPersonnes = $nbPersonnes;

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

    public function getTabl(): ?Table
    {
        return $this->tabl;
    }

    public function setTabl(?Table $tabl): self
    {
        $this->tabl = $tabl;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
       
        $this->status = $status;

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

    public function getConfirmationDate(): ?\DateTimeInterface
    {
        return $this->confirmationDate;
    }

    public function setConfirmationDate(?\DateTimeInterface $confirmationDate): self
    {
        $this->confirmationDate = $confirmationDate;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCancelDate(): ?\DateTimeInterface
    {
        return $this->cancelDate;
    }

    public function setCancelDate(?\DateTimeInterface $cancelDate): self
    {
        $this->cancelDate = $cancelDate;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
