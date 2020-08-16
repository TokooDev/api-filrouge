<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilDeSortieRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_Admin')",
 *              "security_message" = "Accès refusé!"
 *       },
 * normalizationContext ={"groups"={"profilsdesortie:read"}},
 * collectionOperations = {
 *      "getProfilsDeSortie" = {
 *              "method"= "GET",
 *              "path" = "/admin/profilsdesortie"
 *              
 *       },
 *       
 *       "addProfilsDeSortie" = {
 *              "method"= "POST",
 *              "path" = "/admin/profilsdesortie",
 *              "normalization_context"={"groups"={"profilsdesortie:write"}}   
 *       },
 * },
 * itemOperations = {
 *      "getUsersOfProfilDeSortie" = {
 *              "method"= "GET",
 *              "path" = "/admin/profilsdesortie/{id}/users/"
 *              
 *       },
 *      "getProfilDeSortieById" = {
 *              "method"= "GET",
 *              "path" = "/admin/profilsdesortie/{id}"
 *              
 *       },
 *      "editProfilDeSortie"={
 *          "method"= "PUT",
 *          "path"= "/admin/profilsdesortie/{id}"
 *      },
 *      "deleteProfilDeSortie"={
 *          "method"= "DELETE",
 *          "path"= "/admin/profilsdesortie/{id}"
 *      },
 * 
 * },
 * )
 * @ORM\Entity(repositoryClass=ProfilDeSortieRepository::class)
 */
class ProfilDeSortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"profilsdesortie:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profilsdesortie:read","profilsdesortie:write","appreants:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profildesortie")
     * @ApiSubresource
     * @Groups({"profilsdesortie:read"})
     */
    private $apprenants;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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
            $apprenant->setProfildesortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfildesortie() === $this) {
                $apprenant->setProfildesortie(null);
            }
        }

        return $this;
    }
}
