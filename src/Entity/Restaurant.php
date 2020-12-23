<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Core\Annotation\ApiProperty;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"restaurant:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"restaurant:write"},"enable_max_depth"=true}
 * )
 * @ApiFilter(SearchFilter::class, properties={"restaurantOwner.id":"exact","postalCode": "exact","country": "partial","administrativeAreaLevel1": "partial","locality": "partial","route": "partial","streetNumber": "partial", "speciality.label": "exact"})
 * @ORM\Entity(repositoryClass=RestaurantRepository::class)
 * @ORM\Table(schema="food", name="restaurant")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Restaurant
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
     * @Groups({"restaurant:read", "restaurant:write","speciality:read","reservation:read" })
     * 
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"restaurant:read", "restaurant:write","speciality:read","reservation:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"restaurant:read", "restaurant:write"})
     */
    private $minPrice;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"restaurant:read", "restaurant:write"})
     */
    private $dureeLivraison;


    /**
     * @ORM\Column(type="integer")
     * @Groups({"restaurant:read", "restaurant:write"})
     */
    private $nbreLivreur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"restaurant:read", "restaurant:write","speciality:read"})
     */
    private $delivery;

    /**
     * @ORM\Column(type="float")
     * @Groups({"restaurant:read", "restaurant:write","speciality:read"})
     */
    private $prixMinLivraison;

    /**
     * @ORM\ManyToMany(targetEntity=RestaurantService::class, inversedBy="restaurants")
     * @ORM\JoinTable(schema="food", name="restaurant_service")
     * @Groups({"restaurant:read", "restaurant:write"})
     */
    private $services;





    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"restaurant:read", "restaurant:write","speciality:read","reservation:read"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="restaurant")
     * @Groups({"restaurant:read"})
     */
    private $reviews;

    /**
     * @ORM\OneToMany(targetEntity=Table::class, mappedBy="restaurant")
     * @Groups({"restaurant:read"})
     */
    private $tables;

    /**
     * @ORM\OneToMany(targetEntity=MediaObject::class, mappedBy="restaurant")
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"restaurant:read", "restaurant:write","speciality:read"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=Speciality::class, inversedBy="restaurants")
     * @Groups({"restaurant:read", "restaurant:write","reservation:read"})
     */
    private $speciality;


    /**
     * @ORM\OneToMany(targetEntity=Livreur::class, mappedBy="restaurant")
     */
    private $livreurs;

    /**
     * @ORM\OneToOne(targetEntity=RestaurantOwner::class, mappedBy="restaurant", cascade={"persist", "remove"})
     * @Groups({"restaurant:read", "restaurant:write","speciality:read"})
     */
    private $restaurantOwner;



    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"restaurant:read", "restaurant:write"})
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"restaurant:read", "restaurant:write","reservation:read"})
     */
    private $administrativeAreaLevel1;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"restaurant:read", "restaurant:write"})
     */
    private $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"restaurant:read", "restaurant:write","speciality:read","reservation:read"})
     */
    private $country;



    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"restaurant:read", "restaurant:write"})
     */
    private $route;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"restaurant:read", "restaurant:write"})
     */
    private $locality;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="restaurant")
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity=Currency::class, inversedBy="restaurants")
     * @Groups({"restaurant:read", "restaurant:write"})
     */
    private $currency;

    /**
     * @ORM\OneToMany(targetEntity=Menu::class, mappedBy="restaurant")
     * @Groups({"restaurant:read"})
     */
    private $menus;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="restaurant")
     */
    private $reservations;

    /**
     * @ORM\OneToOne(targetEntity=MediaObject::class, cascade={"persist", "remove"})
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"restaurant:read", "restaurant:write","speciality:read"})
     */
    private $logo;



    public function __construct()
    {

        $this->services = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->tables = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->livreurs = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->reservations = new ArrayCollection();
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

    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    public function setMinPrice(int $minPrice): self
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    public function getDureeLivraison(): ?string
    {
        return $this->dureeLivraison;
    }

    public function setDureeLivraison(string $dureeLivraison): self
    {
        $this->dureeLivraison = $dureeLivraison;

        return $this;
    }


    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }


    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(string $locality): self
    {
        $this->locality = $locality;

        return $this;
    }





    public function getNbreLivreur(): ?int
    {
        return $this->nbreLivreur;
    }

    public function setNbreLivreur(int $nbreLivreur): self
    {
        $this->nbreLivreur = $nbreLivreur;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getPrixMinLivraison(): ?float
    {
        return $this->prixMinLivraison;
    }

    public function setPrixMinLivraison(float $prixMinLivraison): self
    {
        $this->prixMinLivraison = $prixMinLivraison;

        return $this;
    }

    /**
     * @return Collection|RestaurantService[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(RestaurantService $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
        }

        return $this;
    }

    public function removeService(RestaurantService $service): self
    {
        if ($this->services->contains($service)) {
            $this->services->removeElement($service);
        }

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getAdministrativeAreaLevel1(): ?string
    {
        return $this->administrativeAreaLevel1;
    }

    public function setAdministrativeAreaLevel1(string $administrativeAreaLevel1): self
    {
        $this->administrativeAreaLevel1 = $administrativeAreaLevel1;

        return $this;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

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

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setRestaurant($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getRestaurant() === $this) {
                $review->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Table[]
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(Table $table): self
    {
        if (!$this->tables->contains($table)) {
            $this->tables[] = $table;
            $table->setRestaurant($this);
        }

        return $this;
    }

    public function removeTable(Table $table): self
    {
        if ($this->tables->contains($table)) {
            $this->tables->removeElement($table);
            // set the owning side to null (unless already changed)
            if ($table->getRestaurant() === $this) {
                $table->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MediaObject[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(MediaObject $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setRestaurant($this);
        }

        return $this;
    }

    public function removeImage(MediaObject $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getRestaurant() === $this) {
                $image->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }





    /**
     * @return Collection|Livreur[]
     */
    public function getLivreurs(): Collection
    {
        return $this->livreurs;
    }

    public function addLivreur(Livreur $livreur): self
    {
        if (!$this->livreurs->contains($livreur)) {
            $this->livreurs[] = $livreur;
            $livreur->setRestaurant($this);
        }

        return $this;
    }

    public function removeLivreur(Livreur $livreur): self
    {
        if ($this->livreurs->contains($livreur)) {
            $this->livreurs->removeElement($livreur);
            // set the owning side to null (unless already changed)
            if ($livreur->getRestaurant() === $this) {
                $livreur->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getRestaurantOwner(): ?RestaurantOwner
    {
        return $this->restaurantOwner;
    }

    public function setRestaurantOwner(?RestaurantOwner $restaurantOwner): self
    {
        $this->restaurantOwner = $restaurantOwner;

        // set (or unset) the owning side of the relation if necessary
        $newRestaurant = null === $restaurantOwner ? null : $this;
        if ($restaurantOwner->getRestaurant() !== $newRestaurant) {
            $restaurantOwner->setRestaurant($newRestaurant);
        }

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
            $order->setRestaurant($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getRestaurant() === $this) {
                $order->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setRestaurant($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->contains($menu)) {
            $this->menus->removeElement($menu);
            // set the owning side to null (unless already changed)
            if ($menu->getRestaurant() === $this) {
                $menu->setRestaurant(null);
            }
        }

        return $this;
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
            $reservation->setRestaurant($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getRestaurant() === $this) {
                $reservation->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?MediaObject
    {
        return $this->logo;
    }

    public function setLogo(?MediaObject $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}
