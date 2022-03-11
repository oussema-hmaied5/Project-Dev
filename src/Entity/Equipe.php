<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_equipe;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_joueurs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_joueurs;

    /**
     * @ORM\ManyToMany(targetEntity=Tournois::class, mappedBy="equipes_participantes")
     **@ORM\JoinColumn(nullable=true)

     */
    private $Tournois;

    public function __construct()
    {
        $this->Tournois = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEquipe(): ?string
    {
        return $this->nom_equipe;
    }

    public function setNomEquipe(string $nom_equipe): self
    {
        $this->nom_equipe = $nom_equipe;

        return $this;
    }

    public function getNbrJoueurs(): ?int
    {
        return $this->nbr_joueurs;
    }

    public function setNbrJoueurs(int $nbr_joueurs): self
    {
        $this->nbr_joueurs = $nbr_joueurs;

        return $this;
    }

    public function getNomJoueurs(): ?string
    {
        return $this->nom_joueurs;
    }

    public function setNomJoueurs(string $nom_joueurs): self
    {
        $this->nom_joueurs = $nom_joueurs;

        return $this;
    }

    /**
     * @return Collection<int, Tournois>
     */
    public function getTournois(): Collection
    {
        return $this->Tournois;
    }

    public function addTournoi(Tournois $tournoi): self
    {
        if (!$this->Tournois->contains($tournoi)) {
            $this->Tournois[] = $tournoi;
            $tournoi->addEquipesParticipante($this);
        }

        return $this;
    }

    public function removeTournoi(Tournois $tournoi): self
    {
        if ($this->Tournois->removeElement($tournoi)) {
            $tournoi->removeEquipesParticipante($this);
        }

        return $this;
    }
    public function __toString() : String
    {
        return $this->id.$this->nbr_joueurs.$this->nom_equipe.$this->nom_joueurs;
    }
}
