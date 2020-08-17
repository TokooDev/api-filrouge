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
     * @Groups({"competencesEtNiveaux:read","competencesEtNiveaux:write"})
     */
    private $Actions;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competencesEtNiveaux:read","competencesEtNiveaux:write"})
     */
    private $Criteres;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, mappedBy="niveauDevaluation")
     */
    private $competences;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
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
}
