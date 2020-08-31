<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
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
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Discussion::class, inversedBy="commentaire")
     * @Groups({"commentaires:read","commentaires:write"})
     */
    private $discussion;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $fichier;

    /**
     * @ORM\Column(type="date")
     * @Groups({"commentaires:read","commentaires:write"})
     */
    private $heur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

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

    public function getFichier()
    {
        return $this->fichier;
    }

    public function setFichier($fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getHeur(): ?\DateTimeInterface
    {
        return $this->heur;
    }

    public function setHeur(\DateTimeInterface $heur): self
    {
        $this->heur = $heur;

        return $this;
    }
}
