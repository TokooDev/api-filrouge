<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeDeCompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * collectionOperations={
 *          "getcompetences"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/grpecompetences",  
 *              "normalization_context"={"groups"={"groupecomp:read"}},  
 *          }, 
 *      "getGrpcompCompetences"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/grpecompetences/competences", 
 *              "normalization_context"={"groups"={"groupecompcomp:read"}},
 *                 
 *          }, 
 *        "postGrpCompetences"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="admin/grpecompetences", 
 *              "normalization_context"={"groups"={"postgroupecomp:write"}},
 *                 
 *          }, 
 *},

 *itemOperations={
 *     "getcompetencebyID"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/grpecompetences/{id}",  
 *              "normalization_context"={"groups"={"groupecompid:read"}},  
 *          }, 
 * "getgrpcompetencescompetencebyID"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/grpecompetences/{id}/competences ",  
 *              "normalization_context"={"groups"={"groupecompidcomp:read"}},  
 *          }, 
 * "putcompetencebyID"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="PUT",
 *              "path"="/admin/grpecompetences/{id}",  
 *              "normalization_context"={"groups"={"addcompetence:write"}},  
 *          }, 
 * },
 * )
 * @ORM\Entity(repositoryClass=GroupeDeCompetenceRepository::class)
 */
class GroupeDeCompetence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefsofpromo:read","briefs:read","groupecomp:read","groupecompcomp:read","groupecompid:read","groupecompidcomp:read","ref_grpe:read","competence:read","afficherGr:read","grpco:read","grpcom:write"})
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupecomp:read","groupecompcomp:read","groupecompid:read","groupecompidcomp:read","ref_grpe:read","competence:read","afficherGr:read","grpco:read","grpcom:write"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, mappedBy="groupeDeCompetence")
     *  @Groups({"groupecomp:read","groupecompcomp:read","groupecompid:read","groupecompidcomp:read","competence:read","afficherGr:read","grpco:read"})
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="GroupeDeCompetences")
     */
    private $referentiels;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
            $competence->addGroupeDeCompetence($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
            $competence->removeGroupeDeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeDeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->contains($referentiel)) {
            $this->referentiels->removeElement($referentiel);
            $referentiel->removeGroupeDeCompetence($this);
        }

        return $this;
    }
}
