<?php

namespace App\Entity\Colegio;

use App\Repository\Colegio\notasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=notasRepository::class)
 * @ORM\Table(name="colegio.notas")
 */
class notas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=materias::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $materia;

    /**
     * @ORM\ManyToOne(targetEntity=estudiante::class, inversedBy="notas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $estudiante;

    /**
     * @ORM\Column(type="float")
     */
    private $nota;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMateria(): ?materias
    {
        return $this->materia;
    }

    public function setMateria(?materias $materia): self
    {
        $this->materia = $materia;

        return $this;
    }

    public function getEstudiante(): ?estudiante
    {
        return $this->estudiante;
    }

    public function setEstudiante(?estudiante $estudiante): self
    {
        $this->estudiante = $estudiante;

        return $this;
    }

    public function getNota(): ?float
    {
        return $this->nota;
    }

    public function setNota(float $nota): self
    {
        $this->nota = $nota;

        return $this;
    }
}
