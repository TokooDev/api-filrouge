<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * collectionOperations={ 
 *           "ajoutBrief"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="/formateurs/briefs",
 *              "normalization_context"={"groups"={"brief:write"}}, 
 *          },
 *          "dupliquerBrief"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="/formateurs/briefs/{id}",
 *              "normalization_context"={"groups"={"briefe:write"}}, 
 *           },  
 * 
 *         
 * },
 * 
 * )
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 */
class Brief
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $titre;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $modalitePedagogique;

   
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $critersPerformance;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $etat;
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $modaliteDevaluation;
    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, inversedBy="briefs")
     * @Groups({"brief:write"})
     */
    private $promos;

    /**
     * @ORM\OneToMany(targetEntity=Livrable::class, mappedBy="brief")
     * @Groups({"brief:write","briefe:write"})
     */
    private $Livrables;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, mappedBy="briefs")
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $apprenants;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="briefs")
     * @Groups({"brief:write","briefe:write"})
     */
    private $referentiels;

    /**
     * @ORM\ManyToMany(targetEntity=NiveauDevaluation::class, inversedBy="briefs")
     * @Groups({"brief:write","briefe:write"})
     */
    private $niveuEvaluations;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     * @Groups({"brief:write","briefe:write"})
     */
    private $formateurs;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     * @Groups({"brief:write","briefe:write"})
     */
    private $tags;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="briefs")
     * @Groups({"brief:write","briefe:write","briefs:write"})
     */
    private $ressources;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="briefs")
     */
    private $briefMaPromos;

    

    public function __construct()
    {
        $this->promos = new ArrayCollection();
        $this->Livrables = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
        $this->niveuEvaluations = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->ressources = new ArrayCollection();
        $this->briefMaPromos = new ArrayCollection();
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

    public function getReferentiels(): ?Referentiel
    {
        return $this->referentiels;
    }

    public function setReferentiels(?Referentiel $referentiels): self
    {
        $this->referentiels = $referentiels;

        return $this;
    }

    /**
     * @return Collection|NiveauDevaluation[]
     */
    public function getNiveuEvaluations(): Collection
    {
        return $this->niveuEvaluations;
    }

    public function addNiveuEvaluation(NiveauDevaluation $niveuEvaluation): self
    {
        if (!$this->niveuEvaluations->contains($niveuEvaluation)) {
            $this->niveuEvaluations[] = $niveuEvaluation;
        }

        return $this;
    }

    public function removeNiveuEvaluation(NiveauDevaluation $niveuEvaluation): self
    {
        if ($this->niveuEvaluations->contains($niveuEvaluation)) {
            $this->niveuEvaluations->removeElement($niveuEvaluation);
        }

        return $this;
    }

    public function getFormateurs(): ?Formateur
    {
        return $this->formateurs;
    }

    public function setFormateurs(?Formateur $formateurs): self
    {
        $this->formateurs = $formateurs;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setBriefs($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressources->contains($ressource)) {
            $this->ressources->removeElement($ressource);
            // set the owning side to null (unless already changed)
            if ($ressource->getBriefs() === $this) {
                $ressource->setBriefs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefMaPromos(): Collection
    {
        return $this->briefMaPromos;
    }

    public function addBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if (!$this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos[] = $briefMaPromo;
            $briefMaPromo->setBriefs($this);
        }

        return $this;
    }

    public function removeBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if ($this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos->removeElement($briefMaPromo);
            // set the owning side to null (unless already changed)
            if ($briefMaPromo->getBriefs() === $this) {
                $briefMaPromo->setBriefs(null);
            }
        }

        return $this;
    }

   
}
