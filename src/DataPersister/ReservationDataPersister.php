<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Reservation;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ReservationDataPersister implements DataPersisterInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof Reservation;

    }
    /**
     * @param Cart $data
     */
    public function persist($data)
    {
        // TODO: Implement persist() method.
        $data->setDate(new DateTime());
        $data->setRestaurant($data->getTabl()->getRestaurant()) ;
        //$data->setStatus('PENDING');
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        // TODO: Implement remove() method.
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
