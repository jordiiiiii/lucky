<?php

namespace App\Entity;

use App\Repository\OrganismeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrganismeRepository::class)
 */
class Organisme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomorg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NIF;

    /**
     * @ORM\OneToMany(targetEntity=Premi::class, mappedBy="organisme")
     */
    private $premis;

    public function __construct()
    {
        $this->premis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomorg(): ?string
    {
        return $this->nomorg;
    }

    public function setNomorg(string $nomorg): self
    {
        $this->nomorg = $nomorg;

        return $this;
    }

    public function getNIF(): ?string
    {
        return $this->NIF;
    }

    public function setNIF(string $NIF): self
    {
        $this->NIF = $NIF;

        return $this;
    }

    /**
     * @return Collection|Premi[]
     */
    public function getPremis(): Collection
    {
        return $this->premis;
    }

    public function addPremi(Premi $premi): self
    {
        if (!$this->premis->contains($premi)) {
            $this->premis[] = $premi;
            $premi->setOrganisme($this);
        }

        return $this;
    }

    public function removePremi(Premi $premi): self
    {
        if ($this->premis->removeElement($premi)) {
            // set the owning side to null (unless already changed)
            if ($premi->getOrganisme() === $this) {
                $premi->setOrganisme(null);
            }
        }

        return $this;
    }
}
