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
 */
class Apprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ApiSubresource
     * @Groups({"briefsofgroupeofpromo:read","briefsofapprenantofpromo:read","appreants:read","profilsdesortie:read","groupe:read","promo:read","briefsofpromo:read"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="apprenants")
     * @Groups({"appreants:read"})
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity=ProfilDeSortie::class, inversedBy="apprenants")
     * @Groups({"appreants:read"})
     */
    private $profildesortie;

    /**
     * @ORM\ManyToMany(targetEntity=Livrable::class, mappedBy="apprenant")
     */
    private $livrables;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, inversedBy="apprenants")
     */
    private $briefs;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->livrables = new ArrayCollection();
        $this->briefs = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
            $livrable->addApprenant($this);
        }

        return $this;
    }

    public function removeLivrable(Livrable $livrable): self
    {
        if ($this->livrables->contains($livrable)) {
            $this->livrables->removeElement($livrable);
            $livrable->removeApprenant($this);
        }

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

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
        }

        return $this;
    }
}
