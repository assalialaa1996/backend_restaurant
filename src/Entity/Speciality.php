<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity; 
/**
 * @ApiResource(
 *     normalizationContext={"groups"={"speciality:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"speciality:write"}},
 *     collectionOperations={
 *          "get",
 *          "post"
 *          
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={"security"="is_granted('ROLE_ADMIN')",  "security_message"="Only admin can edit speciality."},
 *         "delete"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Only admin or admin can delete speciality."}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"label": "exact"})
 * @ORM\Entity(repositoryClass=SpecialityRepository::class)
 * @ORM\Table(schema="food", name="speciality")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 */
class Speciality
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
     * @Groups({"speciality:read", "speciality:write", "restaurant:read"})
     * 
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"speciality:read", "speciality:write", "restaurant:read"})
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"speciality:read", "speciality:write", "restaurant:read"})
     */
    private $key;

    /**
     * @ORM\OneToMany(targetEntity=Restaurant::class, mappedBy="speciality")
     * 
     */ 
    private $restaurants;

    /**
     * @var MediaObject|null
     * 
     * @ORM\OneToOne(targetEntity=MediaObject::class, cascade={"persist", "remove"})
     * @Groups({"speciality:read", "speciality:write", "restaurant:read"})
     */
    private $image;

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurant $restaurant): self
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants[] = $restaurant;
            $restaurant->setSpeciality($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurant $restaurant): self
    {
        if ($this->restaurants->contains($restaurant)) {
            $this->restaurants->removeElement($restaurant);
            // set the owning side to null (unless already changed)
            if ($restaurant->getSpeciality() === $this) {
                $restaurant->setSpeciality(null);
            }
        }

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }
}
