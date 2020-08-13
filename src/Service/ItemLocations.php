<?php

namespace App\Service;
use App\Entity\FreeItem;
use Doctrine\ORM\EntityManagerInterface;

class ItemLocations
{

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function locations()
    {
        $allItemsForAutoComplete = $this->em->getRepository(FreeItem::class)->findAll();

        $allLocations = [];

        foreach ($allItemsForAutoComplete as $location) {

            if (!in_array($location->getLocation(), $allLocations)) {
                array_push($allLocations, $location->getLocation());
            }
        }

        return $allLocations;
    }

}