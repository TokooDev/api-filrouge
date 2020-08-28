<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivrableRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=LivrableRepository::class)
 */
class Livrable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"brief:write","briefe:write","briefsvalidesofformateur:read","briefsbrouillonsofformateur:read","briefsbrouillonofformateur:read","briefsofapprenantofpromo:read","briefs:read","briefsofpromo:read","briefsofgroupeofpromo:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="Livrables")
     */
    private $brief;

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartiel::class, mappedBy="livrable")
     * @Groups({"briefs:write"})
     */
    private $livrablePartiels;

    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"briefs:write","briefe:write"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=LivrableAttendusApprenant::class, mappedBy="Livrable")
     */
    private $livrableAttendusApprenants;

   

    public function __construct()
    {
        $this->livrablePartiels = new ArrayCollection();
        $this->apprenant = new ArrayCollection();
        $this->livrableAttendusApprenants = new ArrayCollection();
    }

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

   

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * @return Collection|LivrablePartiel[]
     */
    public function getLivrablePartiels(): Collection
    {
        return $this->livrablePartiels;
    }

    public function addLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if (!$this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels[] = $livrablePartiel;
            $livrablePartiel->setLivrable($this);
        }

        return $this;
    }

    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels->removeElement($livrablePartiel);
            // set the owning side to null (unless already changed)
            if ($livrablePartiel->getLivrable() === $this) {
                $livrablePartiel->setLivrable(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|LivrableAttendusApprenant[]
     */
    public function getLivrableAttendusApprenants(): Collection
    {
        return $this->livrableAttendusApprenants;
    }

    public function addLivrableAttendusApprenant(LivrableAttendusApprenant $livrableAttendusApprenant): self
    {
        if (!$this->livrableAttendusApprenants->contains($livrableAttendusApprenant)) {
            $this->livrableAttendusApprenants[] = $livrableAttendusApprenant;
            $livrableAttendusApprenant->setLivrable($this);
        }

        return $this;
    }

    public function removeLivrableAttendusApprenant(LivrableAttendusApprenant $livrableAttendusApprenant): self
    {
        if ($this->livrableAttendusApprenants->contains($livrableAttendusApprenant)) {
            $this->livrableAttendusApprenants->removeElement($livrableAttendusApprenant);
            // set the owning side to null (unless already changed)
            if ($livrableAttendusApprenant->getLivrable() === $this) {
                $livrableAttendusApprenant->setLivrable(null);
            }
        }

        return $this;
    }

    
}
