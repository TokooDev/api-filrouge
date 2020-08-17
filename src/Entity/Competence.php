<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * collectionOperations={
 *                      "getcomp"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/competences",  
 *              "normalization_context"={"groups"={"competencesEtNiveaux:read"}},  
 *          }, 
 *      "postcomp"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="/admin/competences", 
 *              "normalization_context"={"groups"={"competencesEtNiveaux:write"}},
 *                 
 *          }, 
 *                 
*                    
*                      },    
                        
*itemOperations={
 *     "getcompbyID"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/admin/competences/{id}",  
 *              "normalization_context"={"groups"={"compgetid:read"}},  
 *          }, 
 * "putcompbyID"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="PUT",
 *              "path"="/admin/competences/{id}",  
 *              "normalization_context"={"groups"={"compgetid:write"}},  
 *          }, 
 * }, 
 * )
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *@Groups({"competencesEtNiveaux:read","competencesEtNiveaux:write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competencesEtNiveaux:read","competencesEtNiveaux:write"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=NiveauDevaluation::class, inversedBy="competences")
     * @Groups({"competencesEtNiveaux:read","competencesEtNiveaux:write"})
     */
    private $niveauDevaluation;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeDeCompetence::class, inversedBy="competences")
     */
    private $groupeDeCompetence;

    public function __construct()
    {
        $this->niveauDevaluation = new ArrayCollection();
        $this->groupeDeCompetence = new ArrayCollection();
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
     * @return Collection|NiveauDevaluation[]
     */
    public function getNiveauDevaluation(): Collection
    {
        return $this->niveauDevaluation;
    }

    public function addNiveauDevaluation(NiveauDevaluation $niveauDevaluation): self
    {
        if (!$this->niveauDevaluation->contains($niveauDevaluation)) {
            $this->niveauDevaluation[] = $niveauDevaluation;
        }

        return $this;
    }

    public function removeNiveauDevaluation(NiveauDevaluation $niveauDevaluation): self
    {
        if ($this->niveauDevaluation->contains($niveauDevaluation)) {
            $this->niveauDevaluation->removeElement($niveauDevaluation);
        }

        return $this;
    }

    /**
     * @return Collection|GroupeDeCompetence[]
     */
    public function getGroupeDeCompetence(): Collection
    {
        return $this->groupeDeCompetence;
    }

    public function addGroupeDeCompetence(GroupeDeCompetence $groupeDeCompetence): self
    {
        if (!$this->groupeDeCompetence->contains($groupeDeCompetence)) {
            $this->groupeDeCompetence[] = $groupeDeCompetence;
        }

        return $this;
    }

    public function removeGroupeDeCompetence(GroupeDeCompetence $groupeDeCompetence): self
    {
        if ($this->groupeDeCompetence->contains($groupeDeCompetence)) {
            $this->groupeDeCompetence->removeElement($groupeDeCompetence);
        }

        return $this;
    }
}
