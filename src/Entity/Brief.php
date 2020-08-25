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
 * normalizationContext ={"groups"={"briefs:read"}},
 * collectionOperations = {
 *      "getBriefs" = {
 *              "security" = "is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *              "security_message" = "Accès refusé!",
 *              "method"= "GET",
 *              "path" = "/formateurs/briefs"  
 *       },
 * 
 *       "getBriefsOfGroupeOfPromo"={
 *              "security"="is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/formateurs/promos/{idP}/groupes/{idG}/briefs",
 *              "normalization_context"={"groups"={"briefsofgroupeofpromo:read"}},
 *        },
 * 
 *        "getBriefsBrouillonsOfFormateur"={
 *              "security"="is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/formateurs/{id}/briefs/brouillons",
 *              "normalization_context"={"groups"={"briefsbrouillonofformateur:read"}},
 *        }
 * },
 * )
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 */
class Brief
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"briefs:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"briefsbrouillonofformateur:read","briefs:read","briefsofpromo:read","briefsofapprenantofpromo:read","briefsofgroupeofpromo:read"})
     */
    private $titre;

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"briefs:read"})
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"briefs:read"})
     */
    private $modalitePedagogique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"briefsbrouillonofformateur:read","briefsofapprenantofpromo:read","briefs:read","briefsofpromo:read","briefsofgroupeofpromo:read"})
     */
    private $ressource;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"briefs:read"})
     */
    private $critersPerformance;

    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"briefs:read"})
     */
    private $etat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"briefs:read"})
     */
    private $modaliteDevaluation;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, inversedBy="briefs")
     * @Groups({"briefsofgroupeofpromo:read"})
     */
    private $promos;

    /**
     * @ORM\OneToMany(targetEntity=Livrable::class, mappedBy="brief")
     * @Groups({"briefsbrouillonofformateur:read","briefsofapprenantofpromo:read","briefs:read","briefsofpromo:read","briefsofgroupeofpromo:read"})
     */
    private $Livrables;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, mappedBy="briefs")
     * 
     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="briefs")
     * @Groups({"briefsbrouillonofformateur:read","briefsofapprenantofpromo:read","briefs:read","briefsofpromo:read","briefsofgroupeofpromo:read"})
     */
    private $competences;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="briefs")
     * @Groups({"briefsofpromo:read","briefsofapprenantofpromo:read","briefsofgroupeofpromo:read"})
     */
    private $referentiel;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="briefs")
     * @Groups({"briefsofpromo:read","briefsofapprenantofpromo:read","briefsofgroupeofpromo:read"})
     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="briefs")
     * @Groups({"briefsofapprenantofpromo:read","briefsofpromo:read","briefsofgroupeofpromo:read"})
     */
    private $formateurs;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valide;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $brouillon;

    public function __construct()
    {
        $this->promos = new ArrayCollection();
        $this->Livrables = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
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

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
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
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
        }

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->contains($formateur)) {
            $this->formateurs->removeElement($formateur);
        }

        return $this;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getBrouillon(): ?bool
    {
        return $this->brouillon;
    }

    public function setBrouillon(?bool $brouillon): self
    {
        $this->brouillon = $brouillon;

        return $this;
    }
}
