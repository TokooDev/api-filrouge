<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\LivrableAttendusApprenantRepository;

/**
 * @ApiResource(
 *  collectionOperations={
 *  "ajoutUrl"={
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_Formateur')",
 *              "security_message"="ACCES REFUSE",
 *              "method"="POST",
 *              "path"="api/apprenants/{id_app}/groupe/{id_gr}/livrables",
 *              
 *          }, 
 * },)
 * @ORM\Entity(repositoryClass=LivrableAttendusApprenantRepository::class)
 */
class LivrableAttendusApprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="livrableAttendusApprenant")
     *
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Livrable::class, inversedBy="livrableAttendusApprenants", cascade={"persist"})
     */
    private $Livrable;

    

    public function __construct()
    {
        $this->apprenant = new ArrayCollection();
        $this->livrable = new ArrayCollection();
    }

    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
            $apprenant->setLivrableAttendusApprenant($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenant->contains($apprenant)) {
            $this->apprenant->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getLivrableAttendusApprenant() === $this) {
                $apprenant->setLivrableAttendusApprenant(null);
            }
        }

        return $this;
    }

    public function getLivrable(): ?Livrable
    {
        return $this->Livrable;
    }

    public function setLivrable(?Livrable $Livrable): self
    {
        $this->Livrable = $Livrable;

        return $this;
    }

    

    
}
