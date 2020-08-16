<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_Admin')",
 *              "security_message" = "Accès refusé!"
 *       },
 * normalizationContext ={"groups"={"profil:read"}},
 * collectionOperations = {
 *      "getProfils" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils"
 *              
 *       },
 *       
 *       "addProfil" = {
 *              "method"= "POST",
 *              "path" = "/admin/profils",
 *              "normalization_context"={"groups"={"profil:write"}}   
 *       },
 * },
 * 
 * itemOperations = {
 *      "getUsersOfProfil" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils/{id}/users/"
 *              
 *       },
 *      "getProfilById" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils/{id}"
 *              
 *       },
 *      "editProfil"={
 *          "method"= "PUT",
 *          "path"= "/admin/profils/{id}"
 *      },
 *      "deleteProfil"={
 *          "method"= "DELETE",
 *          "path"= "/admin/profils/{id}"
 *      },
 * 
 * },
 *       
 * )
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 */
class Profil
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"profil:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le libelle ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le libelle ne doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le libelle ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"users:read","profil:read","profil:write"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Groups({"profil:read"})
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

        return $this;
    }
}
