<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;




    /**
     * @ORM\ManyToOne(targetEntity=Cadeau::class, inversedBy="paniers")
     */
    private $cadeau;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="paniers")
     */
    private $person;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isValide;



    public function getId(): ?int
    {
        return $this->id;
    }





    public function getCadeau(): ?Cadeau
    {
        return $this->cadeau;
    }

    public function setCadeau(?Cadeau $cadeau): self
    {
        $this->cadeau = $cadeau;

        return $this;
    }

    public function getPerson(): ?User
    {
        return $this->person;
    }

    public function setPerson(?User $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getIsValide(): ?bool
    {
        return $this->isValide;
    }

    public function setIsValide(?bool $isValide): self
    {
        $this->isValide = $isValide;

        return $this;
    }

    public function ReturnIsValide()
    {
        if($this->isValide){
            return "OUI";
        }else {
            return "NON";
        }
    }

}
