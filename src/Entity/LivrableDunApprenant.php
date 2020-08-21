<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrableDunApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrableDunApprenantRepository::class)
 */
class LivrableDunApprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $github;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $trello;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $figma;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $deploiement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fichier;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="livrablesDunApprenant")
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Livrable::class, inversedBy="LivrableDunApprenant")
     */
    private $livrable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(string $github): self
    {
        $this->github = $github;

        return $this;
    }

    public function getTrello(): ?string
    {
        return $this->trello;
    }

    public function setTrello(string $trello): self
    {
        $this->trello = $trello;

        return $this;
    }

    public function getFigma(): ?string
    {
        return $this->figma;
    }

    public function setFigma(string $figma): self
    {
        $this->figma = $figma;

        return $this;
    }

    public function getDeploiement(): ?string
    {
        return $this->deploiement;
    }

    public function setDeploiement(string $deploiement): self
    {
        $this->deploiement = $deploiement;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

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

    public function getLivrable(): ?Livrable
    {
        return $this->livrable;
    }

    public function setLivrable(?Livrable $livrable): self
    {
        $this->livrable = $livrable;

        return $this;
    }
}
