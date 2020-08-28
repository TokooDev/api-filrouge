<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\UserController;
use App\Repository\UserRepository;
use App\Controller\ArchivageUserController;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(
 * attributes = {
 *              "security" = "is_granted('ROLE_Admin')",
 *              "security_message" = "Accès refusé!"
 *       },
 * normalizationContext ={"groups"={"users:read"}},
 * collectionOperations = {
 *      "adUser"={
 *              "method"="POST",
 *              "route_name"="create",
 *              "path"="/admin/users"    
 *       },
 *       "getUsers" = {
 *              "method"= "GET",
 *              "path" = "/admin/users",
 *              "route_name"= "userList"   
 *       },
 * },
 * itemOperations={
 *      "getUserById"={
 *          "method"= "GET",
 *          "path"= "/admin/users/{id}"  
 *      },
 *      "editUser"={
 *          "method"= "PUT",
 *          "path"= "/admin/users/{id}"  
 *      },
 *      "archiverUser" = {
 *          "method"= "PUT",
 *          "path" = "/admin/users/{id}/archive",
 *          "controller" = ArchivageUserController::class   
 *       }
 * }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"users:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Le username ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Le username ne doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le username ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"users:read","appreants:read","profil:read","briefsofpromo:read"})
     */
    private $username;

    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le mot de passe ne doit pas être vide")
     * @Assert\Length(
     *      min = 4,
     *      max = 8,
     *      minMessage = "Le mot de passe ne doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le mot de passe ne doit pas dépasser {{ limit }} charactères"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le nom ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 80,
     *      minMessage = "Le prénom doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le prénom ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"briefsactiveofformateur:read","briefsofgroupeofpromo:read","briefsofapprenantofpromo:read","users:read","appreants:read","profil:read","profilsdesortie:read","groupe:read","promo:read","briefsofpromo:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le nom ne doit pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le nom ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"briefsactiveofformateur:read","briefsofgroupeofpromo:read","briefsofapprenantofpromo:read","users:read","appreants:read","profil:read","profilsdesortie:read","groupe:read","promo:read","briefsofpromo:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'email ne doit pas être vide")
     * @Assert\Length(
     *      
     *      max = 255,
     *      maxMessage = "L'email ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Assert\Email(
     *     message = "L'adresse '{{ value }}' n'est pas un email valide."
     * )
     * @Groups({"briefsofapprenantofpromo:read","users:read","appreants:read","profil:read","profilsdesortie:read","promo:read","briefsofpromo:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le numero ne doit pas être vide")
     * @Assert\Length(
     *      min = 9,
     *      max = 30,
     *      minMessage = "Le numro de telephone doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le numero de telephone ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"briefsofapprenantofpromo:read","users:read","appreants:read","profil:read","profilsdesortie:read","promo:read","briefsofpromo:read"})
     */
    private $tel;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $archived;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Vueillez donner le genre de l'utilisateur")
     * @Assert\Length(
     *      min = 1,
     *      max = 6,
     *      minMessage = "Le genre de telephone doit avoir au moins {{ limit }} charactères",
     *      maxMessage = "Le genre de telephone ne doit pas dépasser {{ limit }} charactères"
     * )
     * @Groups({"briefsofapprenantofpromo:read","users:read","appreants:read","profil:read","profilsdesortie:read","promo:read","briefsofpromo:read"})
     */
    private $genre;

    /**
     * @ORM\OneToOne(targetEntity=Apprenant::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @ApiSubresource
     * @Groups({"users:read"})
     */
    private $profil;

 
    private $avatar;

    /**
     * @ORM\OneToOne(targetEntity=Formateur::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $formateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(?bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        // set the owning side of the relation if necessary
        if ($apprenant->getUser() !== $this) {
            $apprenant->setUser($this);
        }

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $formateur ? null : $this;
        if ($formateur->getUser() !== $newUser) {
            $formateur->setUser($newUser);
        }

        return $this;
    }
}
