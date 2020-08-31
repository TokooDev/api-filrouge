<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DiscussionLivrablePartielDunApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DiscussionLivrablePartielDunApprenantRepository::class)
 */
class DiscussionLivrablePartielDunApprenant
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
     * @ORM\ManyToOne(targetEntity=LivrablePartielDunApprenant::class, inversedBy="discussionLivrablePartielDunApprenants")
     */
    private $livrablepartieldunapprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Discussion::class, inversedBy="discussionLivrablePartielDunApprenants")
     */
    private $discussion;

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

    public function getLivrablepartieldunapprenant(): ?LivrablePartielDunApprenant
    {
        return $this->livrablepartieldunapprenant;
    }

    public function setLivrablepartieldunapprenant(?LivrablePartielDunApprenant $livrablepartieldunapprenant): self
    {
        $this->livrablepartieldunapprenant = $livrablepartieldunapprenant;

        return $this;
    }

    public function getDiscussion(): ?Discussion
    {
        return $this->discussion;
    }

    public function setDiscussion(?Discussion $discussion): self
    {
        $this->discussion = $discussion;

        return $this;
    }
}
