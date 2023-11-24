<?php

namespace App\Entity;

use App\Repository\MenuDuJourRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuDuJourRepository::class)]
class MenuDuJour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Entree = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Proteine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Accompagnement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Dessert = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EntreeSoir = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ProteineSoir = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $AccompagnementSoir = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DessertSoir = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntree(): ?string
    {
        return $this->Entree;
    }

    public function setEntree(?string $Entree): static
    {
        $this->Entree = $Entree;

        return $this;
    }

    public function getProteine(): ?string
    {
        return $this->Proteine;
    }

    public function setProteine(?string $Proteine): static
    {
        $this->Proteine = $Proteine;

        return $this;
    }

    public function getAccompagnement(): ?string
    {
        return $this->Accompagnement;
    }

    public function setAccompagnement(?string $Accompagnement): static
    {
        $this->Accompagnement = $Accompagnement;

        return $this;
    }

    public function getDessert(): ?string
    {
        return $this->Dessert;
    }

    public function setDessert(?string $Dessert): static
    {
        $this->Dessert = $Dessert;

        return $this;
    }

    public function toArray()
    {
        return [
            'Entree' => $this->Entree,
            'Proteine' => $this->Proteine,
            'Accompagnement' => $this->Accompagnement,
            'Dessert' => $this->Dessert,
        ];
    }

    public function getEntreeSoir(): ?string
    {
        return $this->EntreeSoir;
    }

    public function setEntreeSoir(?string $EntreeSoir): static
    {
        $this->EntreeSoir = $EntreeSoir;

        return $this;
    }

    public function getProteineSoir(): ?string
    {
        return $this->ProteineSoir;
    }

    public function setProteineSoir(?string $ProteineSoir): static
    {
        $this->ProteineSoir = $ProteineSoir;

        return $this;
    }

    public function getAccompagnementSoir(): ?string
    {
        return $this->AccompagnementSoir;
    }

    public function setAccompagnementSoir(?string $AccompagnementSoir): static
    {
        $this->AccompagnementSoir = $AccompagnementSoir;

        return $this;
    }

    public function getDessertSoir(): ?string
    {
        return $this->DessertSoir;
    }

    public function setDessertSoir(?string $DessertSoir): static
    {
        $this->DessertSoir = $DessertSoir;

        return $this;
    }
    

}
