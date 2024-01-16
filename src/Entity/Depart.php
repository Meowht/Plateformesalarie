<?php

namespace App\Entity;

use App\Repository\DepartRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartRepository::class)]
class Depart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Prenom = null;

    /**
     * @var array
     */
    #[ORM\Column(type: 'json', nullable: true)]
    private array $profession = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getProfession(): array
    {
        return $this->profession;
    }

    /**
     * @param array $profession
     */
    public function setProfession(array $profession): static
    {
        $this->profession = $profession;

        return $this;
    }
}
