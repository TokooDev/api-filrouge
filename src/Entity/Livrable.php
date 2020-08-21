<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrableRepository::class)
 */
class Livrable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateDeCreation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateDeLivraison;

    /**
     * @ORM\ManyToMany(targetEntity=LivrablePartiel::class, mappedBy="livrables")
     */
    private $livrablePartiels;

    /**
     * @ORM\OneToMany(targetEntity=LivrableDunApprenant::class, mappedBy="livrable")
     */
    private $LivrableDunApprenant;

    public function __construct()
    {
        $this->livrablePartiels = new ArrayCollection();
        $this->LivrableDunApprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDateDeCreation(): ?string
    {
        return $this->dateDeCreation;
    }

    public function setDateDeCreation(string $dateDeCreation): self
    {
        $this->dateDeCreation = $dateDeCreation;

        return $this;
    }

    public function getDateDeLivraison(): ?string
    {
        return $this->dateDeLivraison;
    }

    public function setDateDeLivraison(string $dateDeLivraison): self
    {
        $this->dateDeLivraison = $dateDeLivraison;

        return $this;
    }

    /**
     * @return Collection|LivrablePartiel[]
     */
    public function getLivrablePartiels(): Collection
    {
        return $this->livrablePartiels;
    }

    public function addLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if (!$this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels[] = $livrablePartiel;
            $livrablePartiel->addLivrable($this);
        }

        return $this;
    }

    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels->removeElement($livrablePartiel);
            $livrablePartiel->removeLivrable($this);
        }

        return $this;
    }

    /**
     * @return Collection|LivrableDunApprenant[]
     */
    public function getLivrableDunApprenant(): Collection
    {
        return $this->LivrableDunApprenant;
    }

    public function addLivrableDunApprenant(LivrableDunApprenant $livrableDunApprenant): self
    {
        if (!$this->LivrableDunApprenant->contains($livrableDunApprenant)) {
            $this->LivrableDunApprenant[] = $livrableDunApprenant;
            $livrableDunApprenant->setLivrable($this);
        }

        return $this;
    }

    public function removeLivrableDunApprenant(LivrableDunApprenant $livrableDunApprenant): self
    {
        if ($this->LivrableDunApprenant->contains($livrableDunApprenant)) {
            $this->LivrableDunApprenant->removeElement($livrableDunApprenant);
            // set the owning side to null (unless already changed)
            if ($livrableDunApprenant->getLivrable() === $this) {
                $livrableDunApprenant->setLivrable(null);
            }
        }

        return $this;
    }
}
