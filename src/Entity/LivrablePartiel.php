<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrablePartielRepository::class)
 */
class LivrablePartiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienGithub;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienFigma;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lienTrello;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deploiement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fichier;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateLivraison;

    /**
     * @ORM\ManyToOne(targetEntity=Livrable::class, inversedBy="livrablePartiels")
     */
    private $livrable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getLienGithub(): ?string
    {
        return $this->lienGithub;
    }

    public function setLienGithub(?string $lienGithub): self
    {
        $this->lienGithub = $lienGithub;

        return $this;
    }

    public function getLienFigma(): ?string
    {
        return $this->lienFigma;
    }

    public function setLienFigma(?string $lienFigma): self
    {
        $this->lienFigma = $lienFigma;

        return $this;
    }

    public function getLienTrello(): ?string
    {
        return $this->lienTrello;
    }

    public function setLienTrello(?string $lienTrello): self
    {
        $this->lienTrello = $lienTrello;

        return $this;
    }

    public function getDeploiement(): ?string
    {
        return $this->deploiement;
    }

    public function setDeploiement(?string $deploiement): self
    {
        $this->deploiement = $deploiement;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(?string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(?\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

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
