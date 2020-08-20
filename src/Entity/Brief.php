<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 */
class Brief
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
    private $langue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modalitePedagogique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ressource;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $critersPerformance;

    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $modaliteDevaluation;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, inversedBy="briefs")
     */
    private $promos;

    /**
     * @ORM\OneToMany(targetEntity=Livrable::class, mappedBy="brief")
     */
    private $Livrables;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, mappedBy="briefs")
     */
    private $apprenants;

    public function __construct()
    {
        $this->promos = new ArrayCollection();
        $this->Livrables = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(?string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getModalitePedagogique(): ?string
    {
        return $this->modalitePedagogique;
    }

    public function setModalitePedagogique(?string $modalitePedagogique): self
    {
        $this->modalitePedagogique = $modalitePedagogique;

        return $this;
    }

    public function getRessource(): ?string
    {
        return $this->ressource;
    }

    public function setRessource(?string $ressource): self
    {
        $this->ressource = $ressource;

        return $this;
    }

    public function getCritersPerformance(): ?string
    {
        return $this->critersPerformance;
    }

    public function setCritersPerformance(?string $critersPerformance): self
    {
        $this->critersPerformance = $critersPerformance;

        return $this;
    }

    
    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getModaliteDevaluation(): ?string
    {
        return $this->modaliteDevaluation;
    }

    public function setModaliteDevaluation(?string $modaliteDevaluation): self
    {
        $this->modaliteDevaluation = $modaliteDevaluation;

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
        }

        return $this;
    }

    /**
     * @return Collection|Livrable[]
     */
    public function getLivrables(): Collection
    {
        return $this->Livrables;
    }

    public function addLivrable(Livrable $livrable): self
    {
        if (!$this->Livrables->contains($livrable)) {
            $this->Livrables[] = $livrable;
            $livrable->setBrief($this);
        }

        return $this;
    }

    public function removeLivrable(Livrable $livrable): self
    {
        if ($this->Livrables->contains($livrable)) {
            $this->Livrables->removeElement($livrable);
            // set the owning side to null (unless already changed)
            if ($livrable->getBrief() === $this) {
                $livrable->setBrief(null);
            }
        }

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
            $apprenant->addBrief($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            $apprenant->removeBrief($this);
        }

        return $this;
    }
}
