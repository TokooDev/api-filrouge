<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * collectionOperations={
 *          "getReferentiel"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/referentiels",
 *              "normalization_context"={"groups"={"ref_grpe:read"}}, 
 *          }, 
 *          "getGC"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/referentiels/groupecompetences",
 *              "normalization_context"={"groups"={"competence:read"}},  
 *   
 *          }, 
 *         "getGroupCompetence"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"= "POST",
 *              "path"= "/admin/referentiels", 
 *              "normalization_context"={"groups"={"affiGr:write"}},  
 *      },
 *         
 *      }, 
 * itemOperations={
 * 
 *      "getGroup"={
 *          "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *          "security_message"="ACCES REFUSE",
 *          "method"= "GET",
 *          "path"= "/admin/referentiels/{id}", 
 *          "normalization_context"={"groups"={"afficherGr:read"}},  
 *      },
 *      "getCompetenceGroupe"={
 *          "method"= "GET",
 *          "path"= "/admin/referentiels/{id}/groupecompetences/{id_g}",
 *          "normalization_context"={"groups"={"grpco:read"}},   
 *      },
 *      "ajoutgrpeCompetence"={
 *             "method"="PUT",
 *             "path" = "/admin/referentiels/{id}",
 *             "normalization_context"={"groups"={"grpcom:write"}},
 *      },
 *      "delete_profil"={
 *             "method"="DELETE",
 *             "path" = "/admin/referentiels/{id}",
 *             "normalization_context"={"groups"={"grpcom:write"}},
 *      },
 *
 * },
 * )
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write","ref_grpe:read","competence:read","afficherGr:read","grpco:read","grpcom:write","briefsofgroupeofpromo:read","briefsofapprenantofpromo:read","briefsofpromo:read","ref_grpe:read","competence:read","afficherGr:read","grpco:read","grpcom:write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write","ref_grpe:read","competence:read","afficherGr:read","grpco:read","grpcom:write"})
     */
    private $Presentation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write","ref_grpe:read","competence:read","afficherGr:read","grpco:read","grpcom:write"})
     */
    private $Programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write","ref_grpe:read","competence:read","afficherGr:read","grpco:read","grpcom:write"})
     */
    private $CriteresDevaluations;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief:write","ref_grpe:read","competence:read","afficherGr:read","grpco:read","grpcom:write"})
     */
    private $CriteresDadmissions;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeCompetence::class, inversedBy="referentiels")
     * @Groups({"ref_grpe:read","competence:read","afficherGr:read","grpco:read","grpcom:write"})
     */
    private $GroupeDeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Brief::class, mappedBy="referentiel")
     */
    private $briefs;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="referentiel")
     */
    private $promos;

    public function __construct()
    {
        $this->GroupeDeCompetences = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->promos = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->Presentation;
    }

    public function setPresentation(string $Presentation): self
    {
        $this->Presentation = $Presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->Programme;
    }

    public function setProgramme(string $Programme): self
    {
        $this->Programme = $Programme;

        return $this;
    }

    public function getCriteresDevaluations(): ?string
    {
        return $this->CriteresDevaluations;
    }

    public function setCriteresDevaluations(string $CriteresDevaluations): self
    {
        $this->CriteresDevaluations = $CriteresDevaluations;

        return $this;
    }

    public function getCriteresDadmissions(): ?string
    {
        return $this->CriteresDadmissions;
    }

    public function setCriteresDadmissions(string $CriteresDadmissions): self
    {
        $this->CriteresDadmissions = $CriteresDadmissions;

        return $this;
    }

    /**
     * @return Collection|GroupeDeCompetence[]
     */
    public function getGroupeDeCompetences(): Collection
    {
        return $this->GroupeDeCompetences;
    }

    public function addGroupeDeCompetence(GroupeDeCompetence $groupeDeCompetence): self
    {
        if (!$this->GroupeDeCompetences->contains($groupeDeCompetence)) {
            $this->GroupeDeCompetences[] = $groupeDeCompetence;
        }

        return $this;
    }

    public function removeGroupeDeCompetence(GroupeDeCompetence $groupeDeCompetence): self
    {
        if ($this->GroupeDeCompetences->contains($groupeDeCompetence)) {
            $this->GroupeDeCompetences->removeElement($groupeDeCompetence);
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
            $brief->setReferentiel($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            // set the owning side to null (unless already changed)
            if ($brief->getReferentiel() === $this) {
                $brief->setReferentiel(null);
            }
        }

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
            $promo->addReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            $promo->removeReferentiel($this);
        }

        return $this;
    }
}
