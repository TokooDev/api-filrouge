<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_Admin')",
 *              "security_message" = "Accès refusé!"
 *       },
 * collectionOperations = {
 *      "getProfils" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils",
 *              "normalization_context"={"groups"={"profil:read"}},
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
 *              "path" = "/admin/profils/{id}/users",
 *              "normalization_context"={"groups"={"usersofprofil:read"}},
 *              
 *       },
 *      "getProfilById" = {
 *              "method"= "GET",
 *              "path" = "/admin/profils/{id}",
 *              "normalization_context"={"groups"={"profilbyid:read"}},
 *              
 *       },
 *      "editProfil"={
 *          "method"= "PUT",
 *          "path"= "/admin/profils/{id}", 
 *          "normalization_context"={"groups"={"editprofil:read"}}, 
 *      },
 *      "deleteProfil"={
 *          "method"= "DELETE",
 *          "path"= "/admin/profils/{id}", 
 *          "normalization_context"={"groups"={"deleteprofil:read"}}, 
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
     * @Groups({"profil:read","profilbyid:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profil:read","profil:write","editprofil:read","profilbyid:read","usersofprofil:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * ApiSubresource
     * @Groups({"profil:read","profil:write","usersofprofil:read"})
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
