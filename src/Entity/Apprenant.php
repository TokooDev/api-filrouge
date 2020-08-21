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
 *      },
 * 
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
     * @Groups({"users:read","appreants:read","profilsdesortie:read","groupe:read","promo:read"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"users:read","appreants:read","profilsdesortie:read","groupe:read","promo:read"})
     */
    private $niveau;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="apprenant", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource
     * @Groups({"appreants:read","profilsdesortie:read","groupe:read","promo:read"})
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
     * @ORM\ManyToMany(targetEntity=LivrablePartiel::class, mappedBy="apprenants")
     */
    private $livrablePartiels;

    /**
     * @ORM\OneToMany(targetEntity=LivrableDunApprenant::class, mappedBy="apprenant")
     */
    private $livrablesDunApprenant;

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartielDunApprenant::class, mappedBy="apprenant")
     */
    private $LivrablePartielDunApprenant;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->livrablePartiels = new ArrayCollection();
        $this->livrablesDunApprenant = new ArrayCollection();
        $this->LivrablePartielDunApprenant = new ArrayCollection();
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

    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels->removeElement($livrablePartiel);
            $livrablePartiel->removeApprenant($this);
        }

        return $this;
    }

    /**
     * @return Collection|LivrableDunApprenant[]
     */
    public function getLivrablesDunApprenant(): Collection
    {
        return $this->livrablesDunApprenant;
    }

    public function addLivrablesDunApprenant(LivrableDunApprenant $livrablesDunApprenant): self
    {
        if (!$this->livrablesDunApprenant->contains($livrablesDunApprenant)) {
            $this->livrablesDunApprenant[] = $livrablesDunApprenant;
            $livrablesDunApprenant->setApprenant($this);
        }

        return $this;
    }

    public function removeLivrablesDunApprenant(LivrableDunApprenant $livrablesDunApprenant): self
    {
        if ($this->livrablesDunApprenant->contains($livrablesDunApprenant)) {
            $this->livrablesDunApprenant->removeElement($livrablesDunApprenant);
            // set the owning side to null (unless already changed)
            if ($livrablesDunApprenant->getApprenant() === $this) {
                $livrablesDunApprenant->setApprenant(null);
            }
        }

        return $this;
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
}
