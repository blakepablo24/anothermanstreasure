<?php

namespace App\Entity;

use App\Repository\LocationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationsRepository::class)
 */
class Locations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalAds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $liveAds;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getTotalAds(): ?int
    {
        return $this->totalAds;
    }

    public function setTotalAds(?int $totalAds): self
    {
        $this->totalAds = $totalAds;

        return $this;
    }

    public function getLiveAds(): ?int
    {
        return $this->liveAds;
    }

    public function setLiveAds(?int $liveAds): self
    {
        $this->liveAds = $liveAds;

        return $this;
    }
}
