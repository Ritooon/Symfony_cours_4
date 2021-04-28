<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarqueRepository::class)
 */
class Marque
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
    private $Libelle;

    /**
     * @ORM\OneToMany(targetEntity=Modele::class, mappedBy="marque")
     */
    private $modeles;

    public function __construct()
    {
        $this->modeles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->Libelle;
    }

    public function setLibelle(string $Libelle): self
    {
        $this->Libelle = $Libelle;

        return $this;
    }

    /**
     * @return Collection|Modele[]
     */
    public function getModele(): Collection
    {
        return $this->modeles;
    }

    public function addModele(Modele $modeles): self
    {
        if (!$this->modeles->contains($modeles)) {
            $this->modeles[] = $modeles;
            $modeles->setMarque($this);
        }

        return $this;
    }

    public function removeModele(Modele $modeles): self
    {
        if ($this->modeles->removeElement($modeles)) {
            // set the owning side to null (unless already changed)
            if ($modeles->getMarque() === $this) {
                $modeles->setMarque(null);
            }
        }

        return $this;
    }
}
