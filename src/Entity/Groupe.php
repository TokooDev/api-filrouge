<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

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
 *      "deleteGroupe"={
 *          "method"= "DELETE",
 *          "path"= "/admin/groupes/{id}"
 *      },
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
     * @ORM\Column(type="string", length=255)
     * @Groups({"appreants:read","groupe:read","promo:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read"})
     */
    private $projet;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, mappedBy="groupe")
     * @Groups({"groupe:read","promo:read"})
     */
    private $apprenants;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes")
     */
    private $promo;

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

    public function getProjet(): ?string
    {
        return $this->projet;
    }

    public function setProjet(string $projet): self
    {
        $this->projet = $projet;

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
}
