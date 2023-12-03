<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 40,
        minMessage: "Le nom de l'auteur doit faire au moins {{ limit }} caractères",
        maxMessage: "Le nom de l'auteur doit faire au plus {{ limit }} caractères"
    )]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 40,
        minMessage: "Le prénom de l'auteur doit faire au moins {{ limit }} caractères",
        maxMessage: "Le prénom de l'auteur doit faire au plus {{ limit }} caractères"
    )]
    #[Assert\NotBlank()]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(min: 3, minMessage: "L'âge minimum est de {{ limit }} ans.")]
    // On ne met pas d'âge maximum pour prendre en compte les vieux auteurs
    private ?int $age = null;

    #[ORM\Column(length: 255,nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 30,
        minMessage: "Le pays de l'auteur doit faire au moins {{ limit }} caractères",
        maxMessage: "Le pays de l'auteur doit faire au plus {{ limit }} caractères"
    )]
    private ?string $pays = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Livre::class)]
    private Collection $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): static
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->setAuteur($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): static
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getAuteur() === $this) {
                $livre->setAuteur(null);
            }
        }

        return $this;
    }
}
