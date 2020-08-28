<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BriefApprenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BriefApprenantRepository::class)
 */
class BriefApprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="briefApprenant")
     */
    private $apprenants;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="briefApprenant",cascade={"persist"})
     */
    private $briefmaPromos;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->briefmaPromos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setBriefApprenant($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getBriefApprenant() === $this) {
                $apprenant->setBriefApprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefmaPromos(): Collection
    {
        return $this->briefmaPromos;
    }

    public function addBriefmaPromo(BriefMaPromo $briefmaPromo): self
    {
        if (!$this->briefmaPromos->contains($briefmaPromo)) {
            $this->briefmaPromos[] = $briefmaPromo;
            $briefmaPromo->setBriefApprenant($this);
        }

        return $this;
    }

    public function removeBriefmaPromo(BriefMaPromo $briefmaPromo): self
    {
        if ($this->briefmaPromos->contains($briefmaPromo)) {
            $this->briefmaPromos->removeElement($briefmaPromo);
            // set the owning side to null (unless already changed)
            if ($briefmaPromo->getBriefApprenant() === $this) {
                $briefmaPromo->setBriefApprenant(null);
            }
        }

        return $this;
    }
}
