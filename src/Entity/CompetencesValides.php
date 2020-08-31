<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetencesValidesRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CompetencesValidesRepository::class)
 */
class CompetencesValides
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="competencesValides")
     * @Groups({"collectionApprenant:read","Apprenant:read"})
     */
    private $competences;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="competencesValides")
     * @Groups({"collectionApprenant:read","Apprenant:read"})
     */
    private $referentiel;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="competencesValides")
     * @Groups({"collectionApprenant:read","Apprenant:read"})
     */
    private $Promo;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="competencesValides")
     */
    private $apprenant;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"collectionApprenant:read","Apprenant:read"})
     */
    private $niveau1;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"collectionApprenant:read","Apprenant:read"})
     */
    private $niveau2;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"collectionApprenant:read","Apprenant:read"})
     */
    private $niveau3;

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getCompetences(): ?Competence
    {
        return $this->competences;
    }

    public function setCompetences(?Competence $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->Promo;
    }

    public function setPromo(?Promo $Promo): self
    {
        $this->Promo = $Promo;

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getNiveau1(): ?bool
    {
        return $this->niveau1;
    }

    public function setNiveau1(bool $niveau1): self
    {
        $this->niveau1 = $niveau1;

        return $this;
    }

    public function getNiveau2(): ?bool
    {
        return $this->niveau2;
    }

    public function setNiveau2(bool $niveau2): self
    {
        $this->niveau2 = $niveau2;

        return $this;
    }

    public function getNiveau3(): ?bool
    {
        return $this->niveau3;
    }

    public function setNiveau3(bool $niveau3): self
    {
        $this->niveau3 = $niveau3;

        return $this;
    }
}
