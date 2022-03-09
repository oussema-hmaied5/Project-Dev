<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
  * @ORM\Table(name="`user`")

 */
class User implements UserInterface , TwoFactorInterface

{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("Oussema")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nom is required")
     * @Groups ("Oussema")
     */
    private $nom;



    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="prenom is required")
     * @Groups ("Oussema")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="adresse is required")
     * @Groups ("Oussema")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="email is required")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @Groups ("Oussema")
     */
    private $email;




    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min="8",minMessage="votre num doit contient 8 chiffre")
     * @Groups ("Oussema")
     */
    private $num;
    public function isEmailAuthEnabled(): bool
    {
        return true; // This can be a persisted field to switch email code authentication on/off
    }

    public function getEmailAuthRecipient(): string
    {
        return $this->email;
    }

    public function getEmailAuthCode(): string
    {
        if (null === $this->authCode) {
            throw new \LogicException('The email authentication code was not set');
        }

        return $this->authCode;
    }

    public function setEmailAuthCode(string $authCode): void
    {
        $this->authCode = $authCode;
    }
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="password is required")
     * @Groups ("Oussema")
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookID;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookAccessToken;




    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="user")
     */
    private $MyReclamation;



    public function __construct()
    {
        $this->MyReclamation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password =$password;

        return $this;
    }


    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->email;// TODO: Implement getUsername() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    /**
     * @return mixed
     */
    public function getFacebookID()
    {
        return $this->facebookID;
    }

    /**
     * @param mixed $facebookID
     */
    public function setFacebookID($facebookID): void
    {
        $this->facebookID = $facebookID;
    }

    /**
     * @return mixed
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * @param mixed $facebookAccessToken
     */
    public function setFacebookAccessToken($facebookAccessToken): void
    {
        $this->facebookAccessToken = $facebookAccessToken;
    }




    /**
     * @return Collection|Reclamation[]
     */
    public function getMyReclamation(): Collection
    {
        return $this->MyReclamation;
    }

    public function addMyReclamation(Reclamation $myReclamation): self
    {
        if (!$this->MyReclamation->contains($myReclamation)) {
            $this->MyReclamation[] = $myReclamation;
            $myReclamation->setUser($this);
        }

        return $this;
    }

    public function removeMyReclamation(Reclamation $myReclamation): self
    {
        if ($this->MyReclamation->removeElement($myReclamation)) {
            // set the owning side to null (unless already changed)
            if ($myReclamation->getUser() === $this) {
                $myReclamation->setUser(null);
            }
        }

        return $this;
    }
}

