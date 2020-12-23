<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 * @ORM\Table(schema="food", name="payment")
 */
class Payment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="paymentInfo", cascade={"persist", "remove"})
     */
    private $commande;

  
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Order
    {
        return $this->commande;
    }

    public function setCommande(?Order $commande): self
    {
        $this->commande = $commande;

        // set (or unset) the owning side of the relation if necessary
        $newPaymentInfo = null === $commande ? null : $this;
        if ($commande->getPaymentInfo() !== $newPaymentInfo) {
            $commande->setPaymentInfo($newPaymentInfo);
        }

        return $this;
    }
  

}
