<?php

namespace App\Entity;

use App\Repository\ContinentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContinentsRepository::class)]
class Continents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Countries>
     */
    #[ORM\OneToMany(targetEntity: Countries::class, mappedBy: 'continents')]
    private Collection $countries;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Countries>
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function addCountry(Countries $country): static
    {
        if (!$this->countries->contains($country)) {
            $this->countries->add($country);
            $country->setContinents($this);
        }

        return $this;
    }

    public function removeCountry(Countries $country): static
    {
        if ($this->countries->removeElement($country)) {
            // set the owning side to null (unless already changed)
            if ($country->getContinents() === $this) {
                $country->setContinents(null);
            }
        }

        return $this;
    }
}
