<?php

namespace App\Entity\Colegio;

use App\Repository\Colegio\tipoIdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=tipoIdRepository::class)
 * @ORM\Table(name="colegio.tipo_id")
 */
class tipoId
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=estudiante::class, mappedBy="tipoid")
     */
    private $estudiantes;

    /**
     * @ORM\Column(type="text")
     */
    private $tipo_id;

    public function __construct()
    {
        $this->estudiantes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, estudiante>
     */
    public function getEstudiantes(): Collection
    {
        return $this->estudiantes;
    }

    public function addEstudiante(estudiante $estudiante): self
    {
        if (!$this->estudiantes->contains($estudiante)) {
            $this->estudiantes[] = $estudiante;
            $estudiante->setTipoid($this);
        }

        return $this;
    }

    public function removeEstudiante(estudiante $estudiante): self
    {
        if ($this->estudiantes->removeElement($estudiante)) {
            // set the owning side to null (unless already changed)
            if ($estudiante->getTipoid() === $this) {
                $estudiante->setTipoid(null);
            }
        }

        return $this;
    }

    public function getTipoId(): ?string
    {
        return $this->tipo_id;
    }

    public function setTipoId(string $tipo_id): self
    {
        $this->tipo_id = $tipo_id;

        return $this;
    }
}
