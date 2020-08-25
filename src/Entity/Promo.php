<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ArchivagePromoController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_Admin')",
 *              "security_message" = "Accès refusé!"
 *       },
 * normalizationContext ={"groups"={"promo:read"}},
 * collectionOperations = {
 *      "getPromos" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos"  
 *       },
 *      "addPromo" = {
 *              "method"= "POST",
 *              "path" = "/admin/promos",
 *              "route_name" = "addPromo"     
 *       }
 * },
 * 
 * itemOperations = {
 *      "getApprenantsOfPromo" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}/apprenants/"
 *              
 *       },
 *      "getPromoById" = {
 *              "method"= "GET",
 *              "path" = "/admin/promos/{id}"
 *              
 *       },
 *      "editPromo"={
 *          "method"= "PUT",
 *          "path"= "/admin/promos/{id}"
 *      },
 *      "archiverPromo" = {
 *          "method"= "PUT",
 *          "path" = "/admin/promos/{id}/archive",
 *          "controller" = ArchivagePromoController::class   
 *       },
 *       
 *      "getBriefsOfPromo"={
 *              "security"="is_granted('ROLE_Admin') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/formateurs/promos/{id}/briefs",
 *              "normalization_context"={"groups"={"briefsofpromo:read"}},
 *          },
 *       "getBriefsOfApprenantsOfPromo"={
 *              "security"="is_granted('ROLE_Admin') or is_granted('ROLE_Apprenant') or is_granted('ROLE_Formateur') or is_granted('ROLE_CM')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/apprenants/promos/{id}/briefs",
 *              "normalization_context"={"groups"={"briefsofapprenantofpromo:read"}},
 *          },
 *          
 * 
 * },
 * )
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 */
class Promo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"promo:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La langue  ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "La langue doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "La langue ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"promo:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le titre  ne doit pas être vide")
     * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "Le titre ne doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le titre ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"promo:read","briefsofpromo:read","briefsofapprenantofpromo:read","briefsofgroupeofpromo:read"})
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"promo:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"promo:read"})
     */
    private $lieu;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"promo:read"})
     */
    private $fabrique;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"promo:read"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"promo:read"})
     */
    private $dateFin;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     * @Groups({"promo:read"})
     */
    private $groupes;


    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="promos")
     * @Groups({"briefsofpromo:read","briefsofapprenantofpromo:read"})
     */
    private $briefs;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, inversedBy="promos")
     */
    private $referentiel;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->referentiel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(?string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

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
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
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
            $brief->addPromo($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removePromo($this);
        }

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiel(): Collection
    {
        return $this->referentiel;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiel->contains($referentiel)) {
            $this->referentiel[] = $referentiel;
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiel->contains($referentiel)) {
            $this->referentiel->removeElement($referentiel);
        }

        return $this;
    }

}
