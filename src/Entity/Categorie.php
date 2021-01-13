<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Cadeau::class, mappedBy="categorie")
     */
    private $cadeaus;

    public function __construct()
    {
        $this->cadeaus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Cadeau[]
     */
    public function getCadeaus(): Collection
    {
        return $this->cadeaus;
    }

    public function addCadeau(Cadeau $cadeau): self
    {
        if (!$this->cadeaus->contains($cadeau)) {
            $this->cadeaus[] = $cadeau;
            $cadeau->setCategorie($this);
        }

        return $this;
    }

    public function removeCadeau(Cadeau $cadeau): self
    {
        if ($this->cadeaus->removeElement($cadeau)) {
            // set the owning side to null (unless already changed)
            if ($cadeau->getCategorie() === $this) {
                $cadeau->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->getName();
    }
}
