<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\LivrablePartielDunApprenantRepository;

/**
 * @ApiResource(
 *  collectionOperations={
*              "getlivrablespartiels"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="formateur/livrablepartiels",  
 *              "normalization_context"={"groups"={"livrables:read"}},  
 *          }, 
 *           "getcommentaires"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="GET",
 *              "path"="/formateurs/livrable_partiels/{id}/commentaires",  
 *              "normalization_context"={"groups"={"commentaires:read"}},  
 *          }, 
 *          "postcommentaires"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="/formateurs/livrable_partiels/{id}/commentaires",  
 *              "normalization_context"={"groups"={"commentaires:write"}},  
 *          }, 
*                      },
 * )
 * @ORM\Entity(repositoryClass=LivrablePartielDunApprenantRepository::class)
 */
class LivrablePartielDunApprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"collectionApprenant:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"collectionApprenant:read"})
     */
    private $Etat;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"collectionApprenant:read"})
     */
    private $delai;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRendu;


    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="LivrablePartielDunApprenant")
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablePartiel::class, inversedBy="livrablePartielDunApprenant")
     */
    private $livrablePartiel;

    /**
     * @ORM\OneToMany(targetEntity=DiscussionLivrablePartielDunApprenant::class, mappedBy="livrablepartieldunapprenant")
     */
    private $discussionLivrablePartielDunApprenants;

    /**
     * @ORM\OneToMany(targetEntity=Discussion::class, mappedBy="livrablePartielDunApprenant")
     */
    private $discussion;

    public function __construct()
    {
        $this->discussionLivrablePartielDunApprenants = new ArrayCollection();
        $this->discussion = new ArrayCollection();
    }

    
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->Etat;
    }

    public function setEtat(string $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    public function getDelai(): ?string
    {
        return $this->delai;
    }

    public function setDelai(string $delai): self
    {
        $this->delai = $delai;

        return $this;
    }

    public function getDateRendu(): ?\DateTimeInterface
    {
        return $this->dateRendu;
    }

    public function setDateRendu(\DateTimeInterface $dateRendu): self
    {
        $this->dateRendu = $dateRendu;

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

    public function getLivrablePartiel(): ?LivrablePartiel
    {
        return $this->livrablePartiel;
    }

    public function setLivrablePartiel(?LivrablePartiel $livrablePartiel): self
    {
        $this->livrablePartiel = $livrablePartiel;

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
            $discussionLivrablePartielDunApprenant->setLivrablepartieldunapprenant($this);
        }

        return $this;
    }

    public function removeDiscussionLivrablePartielDunApprenant(DiscussionLivrablePartielDunApprenant $discussionLivrablePartielDunApprenant): self
    {
        if ($this->discussionLivrablePartielDunApprenants->contains($discussionLivrablePartielDunApprenant)) {
            $this->discussionLivrablePartielDunApprenants->removeElement($discussionLivrablePartielDunApprenant);
            // set the owning side to null (unless already changed)
            if ($discussionLivrablePartielDunApprenant->getLivrablepartieldunapprenant() === $this) {
                $discussionLivrablePartielDunApprenant->setLivrablepartieldunapprenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Discussion[]
     */
    public function getDiscussion(): Collection
    {
        return $this->discussion;
    }

    public function addDiscussion(Discussion $discussion): self
    {
        if (!$this->discussion->contains($discussion)) {
            $this->discussion[] = $discussion;
            $discussion->setLivrablePartielDunApprenant($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        if ($this->discussion->contains($discussion)) {
            $this->discussion->removeElement($discussion);
            // set the owning side to null (unless already changed)
            if ($discussion->getLivrablePartielDunApprenant() === $this) {
                $discussion->setLivrablePartielDunApprenant(null);
            }
        }

        return $this;
    }

    
}
