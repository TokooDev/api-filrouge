<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NiveauDevaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=NiveauDevaluationRepository::class)
 */
class NiveauDevaluation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competencesEtNiveaux:read","competencesEtNiveaux:write","compgetid:read","compgetid:write","groupecomp:read","groupecompid:read","apprenantscompetences:read","stats:read","Apprenant:read"})
     */
    private $Actions;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competencesEtNiveaux:read","competencesEtNiveaux:write","compgetid:read","compgetid:write","groupecomp:read","groupecompid:read","apprenantscompetences:read"})
     */
    private $Criteres;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, mappedBy="niveauDevaluation")
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="niveauDevaluation")
     */
    private $briefs;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->briefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActions(): ?string
    {
        return $this->Actions;
    }

    public function setActions(string $Actions): self
    {
        $this->Actions = $Actions;

        return $this;
    }

    public function getCriteres(): ?string
    {
        return $this->Criteres;
    }

    public function setCriteres(string $Criteres): self
    {
        $this->Criteres = $Criteres;

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
            $competence->addNiveauDevaluation($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
            $competence->removeNiveauDevaluation($this);
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
            $brief->addNiveauDevaluation($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removeNiveauDevaluation($this);
        }

        return $this;
    }
}
