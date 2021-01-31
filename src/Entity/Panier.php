<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Panier
{
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_VALIDATED = 'validated';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="paniers")
     */
    private $person;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status = self::STATUS_IN_PROGRESS;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Cadeau::class, inversedBy="paniers")
     */
    private $cadeaux;

    public function __construct()
    {
        $this->cadeaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->setCreatedAt(new \DateTime());
    }

    public function getValidatedAt(): ?\DateTimeInterface
    {
        return $this->validatedAt;
    }

    public function setValidatedAt(?\DateTimeInterface $validatedAt): self
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    public function isValidated()
    {
        return $this->status === self::STATUS_VALIDATED;
    }

    /**
     * @return Collection|Cadeau[]
     */
    public function getCadeaux(): Collection
    {
        return $this->cadeaux;
    }

    public function addCadeaux(Cadeau $cadeaux): self
    {
        if (!$this->cadeaux->contains($cadeaux)) {
            $this->cadeaux[] = $cadeaux;
        }

        return $this;
    }

    public function removeCadeaux(Cadeau $cadeaux): self
    {
        $this->cadeaux->removeElement($cadeaux);

        return $this;
    }
}
