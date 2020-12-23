<?php

namespace App\Entity;

use App\Repository\OpeningHoursRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=OpeningHoursRepository::class)
 * @ORM\Table(schema="food", name="openinghours")
 */
class OpeningHours
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $startTime;

    /**
     * @ORM\Column(type="date")
     */
    private $endTime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $openingDays;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getOpeningDays(): ?string
    {
        return $this->openingDays;
    }

    public function setOpeningDays(string $openingDays): self
    {
        $this->openingDays = $openingDays;

        return $this;
    }
}
