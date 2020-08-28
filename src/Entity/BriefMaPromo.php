<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BriefMaPromoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BriefMaPromoRepository::class)
 */
class BriefMaPromo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="briefMaPromos")
     */
    private $promos;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="briefMaPromos")
     */
    private $briefs;

    /**
     * @ORM\ManyToOne(targetEntity=BriefApprenant::class, inversedBy="briefmaPromos",cascade={"persist"})
     */
    private $briefApprenant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $action;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromos(): ?Promo
    {
        return $this->promos;
    }

    public function setPromos(?Promo $promos): self
    {
        $this->promos = $promos;

        return $this;
    }

    public function getBriefs(): ?Brief
    {
        return $this->briefs;
    }

    public function setBriefs(?Brief $briefs): self
    {
        $this->briefs = $briefs;

        return $this;
    }

    public function getBriefApprenant(): ?BriefApprenant
    {
        return $this->briefApprenant;
    }

    public function setBriefApprenant(?BriefApprenant $briefApprenant): self
    {
        $this->briefApprenant = $briefApprenant;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): self
    {
        $this->action = $action;

        return $this;
    }
}
