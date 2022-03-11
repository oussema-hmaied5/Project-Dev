<?php

namespace App\Entity;

use App\Repository\TournoisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TournoisRepository::class)
 */
class Tournois
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $Date;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private $Prize;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private $max_equipes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Lieu;

    /**
     * @ORM\ManyToOne(targetEntity=Jeu::class, inversedBy="Tournois")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idJeu;

    /**
     * @ORM\ManyToMany(targetEntity=Equipe::class, inversedBy="Tournois")
     * @ORM\JoinColumn(nullable=true)
     */
    private $equipes_participantes;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "Tournament name must be at least {{ limit }} characters long",
     *      maxMessage = "Tournament name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;


    public function __construct()
    {
        $this->id_jeu = new ArrayCollection();
        $this->equipes_participantes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getPrize(): ?int
    {
        return $this->Prize;
    }

    public function setPrize(int $Prize): self
    {
        $this->Prize = $Prize;

        return $this;
    }

    public function getMaxEquipes(): ?int
    {
        return $this->max_equipes;
    }

    public function setMaxEquipes(int $max_equipes): self
    {
        $this->max_equipes = $max_equipes;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): self
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getIdJeu(): ?Jeu
    {
        return $this->idJeu;
    }

    public function setIdJeu(?Jeu $idJeu): self
    {
        $this->idJeu = $idJeu;

        return $this;
    }

    /**
     * @return Collection<int, equipe>
     */
    public function getEquipesParticipantes(): Collection
    {
        return $this->equipes_participantes;
    }

    public function addEquipesParticipante(equipe $equipesParticipante): self
    {
        if (!$this->equipes_participantes->contains($equipesParticipante)) {
            $this->equipes_participantes[] = $equipesParticipante;
        }

        return $this;
    }

    public function removeEquipesParticipante(equipe $equipesParticipante): self
    {
        $this->equipes_participantes->removeElement($equipesParticipante);

        return $this;
    }


    public function __toString(): string
    {
        return $this->id.$this->Date->format('Y-m-d').$this->Prize.$this->idJeu.$this->max_equipes.$this->Lieu;

    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

}
