<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DiscussionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DiscussionRepository::class)
 */
class Discussion
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
     * @ORM\ManyToMany(targetEntity=LivrablePartielDunApprenant::class, mappedBy="discussion")
     */
    private $livrablePartielDunApprenants;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="discussion")
     */
    private $commentaires;

    public function __construct()
    {
        $this->livrablePartielDunApprenants = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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

    /**
     * @return Collection|LivrablePartielDunApprenant[]
     */
    public function getLivrablePartielDunApprenants(): Collection
    {
        return $this->livrablePartielDunApprenants;
    }

    public function addLivrablePartielDunApprenant(LivrablePartielDunApprenant $livrablePartielDunApprenant): self
    {
        if (!$this->livrablePartielDunApprenants->contains($livrablePartielDunApprenant)) {
            $this->livrablePartielDunApprenants[] = $livrablePartielDunApprenant;
            $livrablePartielDunApprenant->addDiscussion($this);
        }

        return $this;
    }

    public function removeLivrablePartielDunApprenant(LivrablePartielDunApprenant $livrablePartielDunApprenant): self
    {
        if ($this->livrablePartielDunApprenants->contains($livrablePartielDunApprenant)) {
            $this->livrablePartielDunApprenants->removeElement($livrablePartielDunApprenant);
            $livrablePartielDunApprenant->removeDiscussion($this);
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setDiscussion($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getDiscussion() === $this) {
                $commentaire->setDiscussion(null);
            }
        }

        return $this;
    }
}
