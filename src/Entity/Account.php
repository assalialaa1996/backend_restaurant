<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity; 
/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="kind", type="string")
 * @ORM\DiscriminatorMap({
 *     "admin"="App\Entity\Admin",
 *     "client"="App\Entity\Client",
 *     "restaurantowner"="App\Entity\RestaurantOwner"
 * })
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 * @ORM\Table(schema="food", name="account")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * 
 * 
 */

abstract class Account implements UserInterface
{
    /**
     * Hook SoftDeleteable behavior
     * updates deletedAt field
     */
    use SoftDeleteableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\Column(type="integer")
     * @Groups({"client:read","order:read","reservation:read","owner:read","owner:write"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"client:read","client:write","order:read","reservation:read","owner:read","owner:write"})
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"client:read","client:write","order:read","reservation:read","owner:read","owner:write"})
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @Groups({"client:read","client:write","order:read","reservation:read","owner:read","owner:write"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"client:read","client:write","order:read","reservation:read","owner:read","owner:write"})
     */
    protected $telephone;


   /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"client:read","client:write","order:read" ,"reservation:read","owner:read","owner:write"})
     */
    protected $address;


    /**
     * @ORM\Column(type="datetimetz", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetimetz", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $updateAt;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255)
     * @Groups({"client:write","owner:write"})
     */
    protected $password;

     /**
     * @ORM\Column(type="json")
      * @Groups({"client:read","owner:read"})
     */
    protected $roles = [];

    public function __construct() {
 
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): ?self
    {
        $this->telephone = $telephone;

        return $this;
    }
    
    public function getAddress(): ?String
    {
        return $this->address;
    }

    public function setAddress(String $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
