<?php

namespace App\Entity;

use App\Repository\CountriesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountriesRepository::class)]
class Countries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?int $nb_inhabitants = null;

    #[ORM\Column(length: 255)]
    private ?string $capital_city = null;

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

    public function getNbInhabitants(): ?int
    {
        return $this->nb_inhabitants;
    }

    public function setNbInhabitants(int $nb_inhabitants): static
    {
        $this->nb_inhabitants = $nb_inhabitants;

        return $this;
    }

    public function getCapitalCity(): ?string
    {
        return $this->capital_city;
    }

    public function setCapitalCity(string $capital_city): static
    {
        $this->capital_city = $capital_city;

        return $this;
    }
}
