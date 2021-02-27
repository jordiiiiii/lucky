<?php

namespace App\Entity;

use App\Repository\PremiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PremiRepository::class)
 */
class Premi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $valor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=Organisme::class, inversedBy="premis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(int $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getOrganisme(): ?Organisme
    {
        return $this->organisme;
    }

    public function setOrganisme(?Organisme $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }
}
