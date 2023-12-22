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
    private ?string $Adresse = null;

    #[ORM\OneToMany(mappedBy: 'habitation', targetEntity: Habitant::class, cascade: ['persist'])]
    private Collection $Habitants;

    public function __construct()
    {
        $this->Habitants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->Adresse = $adresse;

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
}
