<?php

namespace App\Entity;

use App\Repository\HabitationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitationRepository::class)]
class Habitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroDeVoie = null;

    #[ORM\Column(length: 255)]
    private ?string $CodePostal = null;

    #[ORM\Column(length: 255)]
    private ?string $Ville = null;

    #[ORM\Column(length: 255)]
    private ?string $Pays = null;

    #[ORM\Column(length: 255)]
    private ?string $Complement = null;

    #[ORM\OneToMany(mappedBy: 'habitation', targetEntity: Habitant::class ,  cascade:['persist'] )]
    private Collection $Habitants;

    #[ORM\Column(length: 255)]
    private ?string $TypeVoie = null;

    public function __construct()
    {
        $this->Habitants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getNumeroDeVoie(): ?string
    {
        return $this->numeroDeVoie;
    }

    public function setNumeroDeVoie(string $numeroDeVoie): static
    {
        $this->numeroDeVoie = $numeroDeVoie;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->CodePostal;
    }

    public function setCodePostal(string $CodePostal): static
    {
        $this->CodePostal = $CodePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): static
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(string $Pays): static
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->Complement;
    }

    public function setComplement(string $Complement): static
    {
        $this->Complement = $Complement;

        return $this;
    }

    /**
     * @return Collection<int, Habitant>
     */
    public function getHabitants(): Collection
    {
        return $this->Habitants;
    }

    public function addHabitant(Habitant $habitant): static
    {
        if (!$this->Habitants->contains($habitant)) {
            $this->Habitants->add($habitant);
            $habitant->setHabitation($this);
        }

        return $this;
    }

    public function removeHabitant(Habitant $habitant): static
    {
        if ($this->Habitants->removeElement($habitant)) {
            // set the owning side to null (unless already changed)
            if ($habitant->getHabitation() === $this) {
                $habitant->setHabitation(null);
            }
        }

        return $this;
    }

    public function getTypeVoie(): ?string
    {
        return $this->TypeVoie;
    }

    public function setTypeVoie(string $TypeVoie): static
    {
        $this->TypeVoie = $TypeVoie;

        return $this;
    }
}
