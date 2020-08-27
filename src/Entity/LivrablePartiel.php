<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * collectionOperations={
 * 
 *              "get_apprenants"={
*                   "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*                   "security_message"="Vous n'avez pas access à cette Ressource",
*                   "method"="GET",
*                   "path"="formateurs/promo/{id}/referentiel/{idp}/competences" ,
*                   "route_name"="get_apprenants",
*                   "normalization_context"={"groups"={"collectionApprenant:read"}},
*                },
*                "get_apprenant"={
*                   "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*                   "security_message"="Vous n'avez pas access à cette Ressource",
*                   "method"="GET",
*                   "path"="apprenant/{id}/promo/{id_promo}/referentiel/{id_ref}/competences" ,
*                   "route_name"="get_apprenant",
*                   "normalization_context"={"groups"={"Apprenant:read"}},
*                },
*               "brief_apprenant"={
*                   "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*                   "security_message"="Vous n'avez pas access à cette Ressource",
*                   "method"="GET",
*                   "path"="apprenants/{id}/promo/{id_promo}/referentiel/{id_ref}/statistiques/briefs" ,
*                   "route_name"="brief_apprenant",
*                   "normalization_context"={"groups"={"Apprenant:read"}},
*                },
*               "statistiques"={
*                   "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*                   "security_message"="Vous n'avez pas access à cette Ressource",
*                   "method"="GET",
*                   "path"="formateurs/promo/{id_promo}/referentiel/{id_ref}/statistiques/competences" ,
*                   "route_name"="statistiques",
*                   "normalization_context"={"groups"={"stats:read"}},
*                   },
*               "commentaires_livrablePartiel"={
*                   "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*                   "security_message"="Vous n'avez pas access à cette Ressource",
*                   "method"="GET",
*                   "path"="formateurs/livrablepartiels/{id}/commentaires" ,
*                   "route_name"="commentaires_livrablePartiel",
*                   "normalization_context"={"groups"={"commentaireslivrablepartiel:read"}},
*                   },
*               "commentaires_livrablePartiel_post"={
*                   "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*                   "security_message"="Vous n'avez pas access à cette Ressource",
*                   "method"="POST",
*                   "path"="formateurs/livrablepartiels/{id}/commentaires" ,
*                   "route_name"="commentaires_livrablePartiel_post",
*                   "normalization_context"={"groups"={"commentaireslivrablepartiel:write"}},
*                   },
*                   "ajout_livrablePartiel"={
*                   "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*                   "security_message"="Vous n'avez pas access à cette Ressource",
*                   "method"="POST",
*                   "path"="formateurs/promo/{id_promo}/brief/{id_br}/livrablepartiels" ,
*                   "route_name"="ajout_livrablePartiel",
*                   
*                   },
*
*},
*itemOperations={
*    "ajout_livrablePartiel"={
*                   "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*                   "security_message"="Vous n'avez pas access à cette Ressource",
*                   "method"="POST",
*                   "path"="formateurs/promo/{id_promo}/brief/{id_br}/livrablepartiels" ,
*                   "route_name"="ajout_livrablePartiel",
*                   "normalization_context"={"groups"={"livrablepartiel:read"}},
*                   },
*
 * }, 
 * )
 * @ORM\Entity(repositoryClass=LivrablePartielRepository::class)
 */
class LivrablePartiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *@Groups({"collectionApprenant:read",})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"collectionApprenant:read","livrablepartiel:write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"livrablepartiel:read","livrablepartiel:write"})
     */
    private $Github;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"livrablepartiel:read","livrablepartiel:write"})
     */
    private $Trello;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"livrablepartiel:read","livrablepartiel:write"})
     */
    private $figma;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"livrablepartiel:read","livrablepartiel:write"})
     */
    private $deploiement;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"livrablepartiel:read","livrablepartiel:write"})
     */
    private $fichier;

    /**
     * @ORM\Column(type="date")
     * @Groups({"livrablepartiel:write"})
     */
    private $DateDeCreation;

    /**
     * @ORM\Column(type="date")
     * @Groups({"livrablepartiel:write"})
     */
    private $DateDeLivraison;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="livrablePartiels")
     * @Groups({"collectionApprenant:read","stats:read","Apprenant:read","livrablepartiel:write"})
     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="livrablePartiels")
     */
    private $formateurs;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="livrablePartiels")
     *  @Groups({"livrablepartiel:write"})
     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity=Livrable::class, inversedBy="livrablePartiels")
     */
    private $livrables;

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartielDunApprenant::class, mappedBy="livrablePartiel")
     */
    private $livrablePartielDunApprenant;

    
    
    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->livrables = new ArrayCollection();
        $this->livrablePartielDunApprenant = new ArrayCollection();
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

    public function getGithub(): ?string
    {
        return $this->Github;
    }

    public function setGithub(string $Github): self
    {
        $this->Github = $Github;

        return $this;
    }

    public function getTrello(): ?string
    {
        return $this->Trello;
    }

    public function setTrello(string $Trello): self
    {
        $this->Trello = $Trello;

        return $this;
    }

    public function getFigma(): ?string
    {
        return $this->figma;
    }

    public function setFigma(string $figma): self
    {
        $this->figma = $figma;

        return $this;
    }

    public function getDeploiement(): ?string
    {
        return $this->deploiement;
    }

    public function setDeploiement(string $deploiement): self
    {
        $this->deploiement = $deploiement;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getDateDeCreation(): ?\DateTimeInterface
    {
        return $this->DateDeCreation;
    }

    public function setDateDeCreation(\DateTimeInterface $DateDeCreation): self
    {
        $this->DateDeCreation = $DateDeCreation;

        return $this;
    }

    public function getDateDeLivraison(): ?\DateTimeInterface
    {
        return $this->DateDeLivraison;
    }

    public function setDateDeLivraison(\DateTimeInterface $DateDeLivraison): self
    {
        $this->DateDeLivraison = $DateDeLivraison;

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
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
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
     * @return Collection|Livrable[]
     */
    public function getLivrables(): Collection
    {
        return $this->livrables;
    }

    public function addLivrable(Livrable $livrable): self
    {
        if (!$this->livrables->contains($livrable)) {
            $this->livrables[] = $livrable;
        }

        return $this;
    }

    public function removeLivrable(Livrable $livrable): self
    {
        if ($this->livrables->contains($livrable)) {
            $this->livrables->removeElement($livrable);
        }

        return $this;
    }

    /**
     * @return Collection|LivrablePartielDunApprenant[]
     */
    public function getLivrablePartielDunApprenant(): Collection
    {
        return $this->livrablePartielDunApprenant;
    }

    public function addLivrablePartielDunApprenant(LivrablePartielDunApprenant $livrablePartielDunApprenant): self
    {
        if (!$this->livrablePartielDunApprenant->contains($livrablePartielDunApprenant)) {
            $this->livrablePartielDunApprenant[] = $livrablePartielDunApprenant;
            $livrablePartielDunApprenant->setLivrablePartiel($this);
        }

        return $this;
    }

    public function removeLivrablePartielDunApprenant(LivrablePartielDunApprenant $livrablePartielDunApprenant): self
    {
        if ($this->livrablePartielDunApprenant->contains($livrablePartielDunApprenant)) {
            $this->livrablePartielDunApprenant->removeElement($livrablePartielDunApprenant);
            // set the owning side to null (unless already changed)
            if ($livrablePartielDunApprenant->getLivrablePartiel() === $this) {
                $livrablePartielDunApprenant->setLivrablePartiel(null);
            }
        }

        return $this;
    }
   
}
