<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Github;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Trello;

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
     * @ORM\Column(type="date")
     */
    private $DateDeCreation;

    /**
     * @ORM\Column(type="date")
     */
    private $DateDeLivraison;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="livrablePartiels")
     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="livrablePartiels")
     */
    private $formateurs;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, inversedBy="livrablePartiels")
     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity=Livrable::class, inversedBy="livrablePartiels")
     */
    private $livrables;

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartielDunApprenant::class, mappedBy="livrablePartiel")
     */
    private $livrablePartielDunApprenant;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->livrables = new ArrayCollection();
        $this->livrablePartielDunApprenant = new ArrayCollection();
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

    public function getGithub(): ?string
    {
        return $this->Github;
    }

    public function setGithub(string $Github): self
    {
        $this->Github = $Github;

        return $this;
    }

    public function getTrello(): ?string
    {
        return $this->Trello;
    }

    public function setTrello(string $Trello): self
    {
        $this->Trello = $Trello;

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

    public function getDateDeCreation(): ?\DateTimeInterface
    {
        return $this->DateDeCreation;
    }

    public function setDateDeCreation(\DateTimeInterface $DateDeCreation): self
    {
        $this->DateDeCreation = $DateDeCreation;

        return $this;
    }

    public function getDateDeLivraison(): ?\DateTimeInterface
    {
        return $this->DateDeLivraison;
    }

    public function setDateDeLivraison(\DateTimeInterface $DateDeLivraison): self
    {
        $this->DateDeLivraison = $DateDeLivraison;

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
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
        }

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->contains($formateur)) {
            $this->formateurs->removeElement($formateur);
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
        }

        return $this;
    }

    /**
     * @return Collection|Livrable[]
     */
    public function getLivrables(): Collection
    {
        return $this->livrables;
    }

    public function addLivrable(Livrable $livrable): self
    {
        if (!$this->livrables->contains($livrable)) {
            $this->livrables[] = $livrable;
        }

        return $this;
    }

    public function removeLivrable(Livrable $livrable): self
    {
        if ($this->livrables->contains($livrable)) {
            $this->livrables->removeElement($livrable);
        }

        return $this;
    }

    /**
     * @return Collection|LivrablePartielDunApprenant[]
     */
    public function getLivrablePartielDunApprenant(): Collection
    {
        return $this->livrablePartielDunApprenant;
    }

    public function addLivrablePartielDunApprenant(LivrablePartielDunApprenant $livrablePartielDunApprenant): self
    {
        if (!$this->livrablePartielDunApprenant->contains($livrablePartielDunApprenant)) {
            $this->livrablePartielDunApprenant[] = $livrablePartielDunApprenant;
            $livrablePartielDunApprenant->setLivrablePartiel($this);
        }

        return $this;
    }

    public function removeLivrablePartielDunApprenant(LivrablePartielDunApprenant $livrablePartielDunApprenant): self
    {
        if ($this->livrablePartielDunApprenant->contains($livrablePartielDunApprenant)) {
            $this->livrablePartielDunApprenant->removeElement($livrablePartielDunApprenant);
            // set the owning side to null (unless already changed)
            if ($livrablePartielDunApprenant->getLivrablePartiel() === $this) {
                $livrablePartielDunApprenant->setLivrablePartiel(null);
            }
        }

        return $this;
    }
}
