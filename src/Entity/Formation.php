<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?site $site = null;

    #[ORM\Column(length: 255)]
    private ?string $date_debut = null;

    #[ORM\Column(length: 255)]
    private ?string $date_fin = null;

    /**
     * @var Collection<int, Module>
     */
    #[ORM\OneToMany(targetEntity: Module::class, mappedBy: 'formation')]
    private Collection $modules;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getSite(): ?site
    {
        return $this->site;
    }

    public function setSite(?site $site): static
    {
        $this->site = $site;

        return $this;
    }




    /**
     * @return Collection<int, Module>
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): static
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
            $module->setFormation($this);
        }

        return $this;
    }

    public function removeModule(Module $module): static
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getFormation() === $this) {
                $module->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of date_fin
     *
     * @return ?string
     */
    public function getDateFin(): ?string
    {
        return $this->date_fin;
    }

    /**
     * Set the value of date_fin
     *
     * @param ?string $date_fin
     *
     * @return self
     */
    public function setDateFin(?string $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    /**
     * Get the value of date_debut
     *
     * @return ?string
     */
    public function getDateDebut(): ?string
    {
        return $this->date_debut;
    }

    /**
     * Set the value of date_debut
     *
     * @param ?string $date_debut
     *
     * @return self
     */
    public function setDateDebut(?string $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }
}
