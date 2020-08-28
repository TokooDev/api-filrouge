<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ArchivageGroupeController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Email;
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
 * normalizationContext ={"groups"={"groupe:read"}},
 * collectionOperations = {
 *      "getGroupes" = {
 *              "method"= "GET",
 *              "path" = "/admin/groupes"  
 *       },
 *      "addGroupe" = {
 *              "method"= "POST",
 *              "path" = "/admin/groupes"     
 *       }
 * },
 * 
 * itemOperations = {
 *      "getApprenantsOfGroupe" = {
 *              "method"= "GET",
 *              "path" = "/admin/groupes/{id}/apprenants/"
 *              
 *       },
 *      "getGroupeById" = {
 *              "method"= "GET",
 *              "path" = "/admin/groupes/{id}"
 *              
 *       },
 *      "editGroupe"={
 *          "method"= "PUT",
 *          "path"= "/admin/groupes/{id}"
 *      },
 *      "archiverGroupe" = {
 *          "method"= "PUT",
 *          "path" = "/admin/groupes/{id}/archive",
 *          "controller" = ArchivageGroupeController::class   
 *       }
 * 
 * },
 * )
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"groupe:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le libelle ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le libelle ne doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le libelle ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"brief:write","briefe:write","briefsofgroupeofpromo:read","briefsofapprenantofpromo:read","appreants:read","groupe:read","briefsofpromo:read","promo:read","briefs:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, mappedBy="groupe")
     * @Groups({"briefsofgroupeofpromo:read","groupe:read","promo:read","briefsofpromo:read","briefsofapprenantofpromo:read"})
     */
    private $apprenants;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes")
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, mappedBy="groupe")
     * 
     */
    private $formateurs;

     /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="groupes")
     */
    private $briefs;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->briefs = new ArrayCollection();
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
            $apprenant->addGroupe($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            $apprenant->removeGroupe($this);
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
            $formateur->addGroupe($this);
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->contains($formateur)) {
            $this->formateurs->removeElement($formateur);
            $formateur->removeGroupe($this);
        }

        return $this;
    }
    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(?bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

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
            $brief->addGroupe($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removeGroupe($this);
        }

        return $this;
    }
}
