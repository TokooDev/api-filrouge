<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_Admin') or is_granted('ROLE_Formateur')",
 *              "security_message" = "Accès refusé!"
 *       },
 * normalizationContext ={"groups"={"appreants:read"}},
 * collectionOperations = {
 *      "getApprenants" = {
 *              "method"= "GET",
 *              "path" = "/admin/apprenants"  
 *       },
 *      "addApprenant" = {
 *              "method"= "POST",
 *              "path" = "/admin/apprenants"    
 *       }
 * },
 * 
 * itemOperations = {
 *      "getGroupesOfApprenant" = {
 *              "method"= "GET",
 *              "path" = "/admin/apprenants/{id}/groupes/"
 *              
 *       },
 *      "getApprenantById" = {
 *              "method"= "GET",
 *              "path" = "/admin/apprenants/{id}"
 *              
 *       },
 *      "editApprenant"={
 *          "method"= "PUT",
 *          "path"= "/admin/apprenants/{id}"
 *      },
 *      "deleteApprenant"={
 *          "method"= "DELETE",
 *          "path"= "/admin/apprenants/{id}"
 *      }
 * },
 * )
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * 
 */
class Apprenant extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")*
     *@Groups({"collectionApprenant:read","Apprenant:read","livrablepartiel:read"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le statut ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le statut ne doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le statut ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"briefsofgroupeofpromo:read","briefsofapprenantofpromo:read","users:read","appreants:read","profilsdesortie:read","groupe:read","promo:read","briefsofpromo:read"})
     */
    private $statut;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"briefsofgroupeofpromo:read","users:read","appreants:read","profilsdesortie:read","groupe:read","promo:read","briefsofpromo:read"})
     */
    private $niveau;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="apprenant", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"briefsofgroupeofpromo:read","briefsofapprenantofpromo:read","appreants:read","profilsdesortie:read","groupe:read","promo:read","briefsofpromo:read"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="apprenants")
     * @Groups({"appreants:read","briefs:write"})
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=ProfilDeSortie::class, inversedBy="apprenants")
     * @Groups({"appreants:read"})
     */
    private $profildesortie;
    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, inversedBy="apprenants")
     */
    private $briefs;
   

    /**
     * @ORM\ManyToOne(targetEntity=LivrableAttendusApprenant::class, inversedBy="apprenant")
     */
    private $livrableAttendusApprenant;

    /**
     * @ORM\ManyToOne(targetEntity=BriefApprenant::class, inversedBy="apprenants")
     */
    private $briefApprenant;
    /**
     * @ORM\ManyToMany(targetEntity=LivrablePartiel::class, mappedBy="apprenants")
     */
    private $livrablePartiels;

   

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartielDunApprenant::class, mappedBy="apprenant")
     */
    private $LivrablePartielDunApprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="apprenants")
     
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="apprenants")
     * @Groups({"stats:read","Apprenant:read"})
     */
    private $referentiel;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="apprenant")
     * @Groups({"collectionApprenant:read","Apprenant:read"})
     */
    private $competencesValides;

    

    
    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->livrables = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->livrableAttendusApprenants = new ArrayCollection();
        $this->livrablePartiels = new ArrayCollection();
        $this->livrablesDunApprenant = new ArrayCollection();
        $this->LivrablePartielDunApprenant = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
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

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

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

    public function getProfildesortie(): ?ProfilDeSortie
    {
        return $this->profildesortie;
    }

    public function setProfildesortie(?ProfilDeSortie $profildesortie): self
    {
        $this->profildesortie = $profildesortie;

        return $this;
    }
    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
        }
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
            $livrablePartiel->addApprenant($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
        }
    }
    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels->removeElement($livrablePartiel);
            $livrablePartiel->removeApprenant($this);
        }

        return $this;
    }

    public function getLivrableAttendusApprenant(): ?LivrableAttendusApprenant
    {
        return $this->livrableAttendusApprenant;
    }

    public function setLivrableAttendusApprenant(?LivrableAttendusApprenant $livrableAttendusApprenant): self
    {
        $this->livrableAttendusApprenant = $livrableAttendusApprenant;
    }
    /**
     * @return Collection|LivrablePartielDunApprenant[]
     */
    public function getLivrablePartielDunApprenant(): Collection
    {
        return $this->LivrablePartielDunApprenant;
    }

    public function addLivrablePartielDunApprenant(LivrablePartielDunApprenant $livrablePartielDunApprenant): self
    {
        if (!$this->LivrablePartielDunApprenant->contains($livrablePartielDunApprenant)) {
            $this->LivrablePartielDunApprenant[] = $livrablePartielDunApprenant;
            $livrablePartielDunApprenant->setApprenant($this);
        }

        return $this;
    }

    public function getBriefApprenant(): ?BriefApprenant
    {
        return $this->briefApprenant;
    }

    public function setBriefApprenant(?BriefApprenant $briefApprenant): self
    {
        $this->briefApprenant = $briefApprenant;
    }
    public function removeLivrablePartielDunApprenant(LivrablePartielDunApprenant $livrablePartielDunApprenant): self
    {
        if ($this->LivrablePartielDunApprenant->contains($livrablePartielDunApprenant)) {
            $this->LivrablePartielDunApprenant->removeElement($livrablePartielDunApprenant);
            // set the owning side to null (unless already changed)
            if ($livrablePartielDunApprenant->getApprenant() === $this) {
                $livrablePartielDunApprenant->setApprenant(null);
            }
        }

        return $this;
    }
    
    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

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
     * @return Collection|CompetencesValides[]
     */
    public function getCompetencesValides(): Collection
    {
        return $this->competencesValides;
    }

    public function addCompetencesValide(CompetencesValides $competencesValide): self
    {
        if (!$this->competencesValides->contains($competencesValide)) {
            $this->competencesValides[] = $competencesValide;
            $competencesValide->setApprenant($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->contains($competencesValide)) {
            $this->competencesValides->removeElement($competencesValide);
            // set the owning side to null (unless already changed)
            if ($competencesValide->getApprenant() === $this) {
                $competencesValide->setApprenant(null);
            }
        }

        return $this;
    }

}
