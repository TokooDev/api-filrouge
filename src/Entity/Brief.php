<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @ORM\ManyToMany(targetEntity=LivrablePartiel::class, inversedBy="briefs")
     */
    private $LivrablePartiel;

    /**
     * @ORM\ManyToMany(targetEntity=Livrable::class, inversedBy="briefs")
     */
    private $livrable;

    /**
     * @ORM\ManyToMany(targetEntity=NiveauDevaluation::class, inversedBy="briefs")
     */
    private $niveauDevaluation;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="briefs")
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="briefs")
     */
    private $referentiel;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="Brief")
     */
    private $promos;

    
    public function __construct()
    {
        $this->LivrablePartiel = new ArrayCollection();
        $this->livrable = new ArrayCollection();
        $this->niveauDevaluation = new ArrayCollection();
        $this->groupe = new ArrayCollection();
        $this->promos = new ArrayCollection();
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
     * @return Collection|LivrablePartiel[]
     */
    public function getLivrablePartiel(): Collection
    {
        return $this->LivrablePartiel;
    }

    public function addLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if (!$this->LivrablePartiel->contains($livrablePartiel)) {
            $this->LivrablePartiel[] = $livrablePartiel;
        }

        return $this;
    }

    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->LivrablePartiel->contains($livrablePartiel)) {
            $this->LivrablePartiel->removeElement($livrablePartiel);
        }

        return $this;
    }

    /**
     * @return Collection|Livrable[]
     */
    public function getLivrable(): Collection
    {
        return $this->livrable;
    }

    public function addLivrable(Livrable $livrable): self
    {
        if (!$this->livrable->contains($livrable)) {
            $this->livrable[] = $livrable;
        }

        return $this;
    }

    public function removeLivrable(Livrable $livrable): self
    {
        if ($this->livrable->contains($livrable)) {
            $this->livrable->removeElement($livrable);
        }

        return $this;
    }

    /**
     * @return Collection|NiveauDevaluation[]
     */
    public function getNiveauDevaluation(): Collection
    {
        return $this->niveauDevaluation;
    }

    public function addNiveauDevaluation(NiveauDevaluation $niveauDevaluation): self
    {
        if (!$this->niveauDevaluation->contains($niveauDevaluation)) {
            $this->niveauDevaluation[] = $niveauDevaluation;
        }

        return $this;
    }

    public function removeNiveauDevaluation(NiveauDevaluation $niveauDevaluation): self
    {
        if ($this->niveauDevaluation->contains($niveauDevaluation)) {
            $this->niveauDevaluation->removeElement($niveauDevaluation);
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->contains($groupe)) {
            $this->groupe->removeElement($groupe);
        }

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

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
            $promo->addBrief($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            $promo->removeBrief($this);
        }

        return $this;
    }

    

}
