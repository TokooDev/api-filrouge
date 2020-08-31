<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DiscussionRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

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
     *  @Groups({"commentaires:read","commentaires:write"})
     */
    private $libelle;

    
    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="discussion")
     *  @Groups({"commentaires:read","commentaires:write","commentaires:read"})
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=DiscussionLivrablePartielDunApprenant::class, mappedBy="discussion")
     */
    private $discussionLivrablePartielDunApprenants;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablePartielDunApprenant::class, inversedBy="discussion")
     */
    private $livrablePartielDunApprenant;

    
    public function __construct()
    {
        
        $this->commentaires = new ArrayCollection();
        $this->discussionLivrablePartielDunApprenants = new ArrayCollection();
       
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

    /**
     * @return Collection|DiscussionLivrablePartielDunApprenant[]
     */
    public function getDiscussionLivrablePartielDunApprenants(): Collection
    {
        return $this->discussionLivrablePartielDunApprenants;
    }

    public function addDiscussionLivrablePartielDunApprenant(DiscussionLivrablePartielDunApprenant $discussionLivrablePartielDunApprenant): self
    {
        if (!$this->discussionLivrablePartielDunApprenants->contains($discussionLivrablePartielDunApprenant)) {
            $this->discussionLivrablePartielDunApprenants[] = $discussionLivrablePartielDunApprenant;
            $discussionLivrablePartielDunApprenant->setDiscussion($this);
        }

        return $this;
    }

    public function removeDiscussionLivrablePartielDunApprenant(DiscussionLivrablePartielDunApprenant $discussionLivrablePartielDunApprenant): self
    {
        if ($this->discussionLivrablePartielDunApprenants->contains($discussionLivrablePartielDunApprenant)) {
            $this->discussionLivrablePartielDunApprenants->removeElement($discussionLivrablePartielDunApprenant);
            // set the owning side to null (unless already changed)
            if ($discussionLivrablePartielDunApprenant->getDiscussion() === $this) {
                $discussionLivrablePartielDunApprenant->setDiscussion(null);
            }
        }

        return $this;
    }

    public function getLivrablePartielDunApprenant(): ?LivrablePartielDunApprenant
    {
        return $this->livrablePartielDunApprenant;
    }

    public function setLivrablePartielDunApprenant(?LivrablePartielDunApprenant $livrablePartielDunApprenant): self
    {
        $this->livrablePartielDunApprenant = $livrablePartielDunApprenant;

        return $this;
    }

    
}
