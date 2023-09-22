<?php

namespace App\Entity\Colegio;

use App\Repository\Colegio\estudianteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="colegio.estudiantes")
 * @ORM\Entity(repositoryClass=estudianteRepository::class)
 */
class estudiante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $apellidos;

    /**
     * @ORM\Column(type="text")
     */
    private $nombres;

    /**
     * @ORM\Column(type="text")
     */
    private $direccion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_nac;

    /**
     * @ORM\Column(type="text")
     */
    private $identificacion;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $edad;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $foto;

    /**
     * @ORM\ManyToOne(targetEntity=tipoId::class, inversedBy="estudiantes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoid;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechaCrea;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fechaMod;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $preferencias;

    /**
     * @ORM\OneToMany(targetEntity=notas::class, mappedBy="estudiante")
     */
    private $notas;

    public function __construct()
    {
        $this->notas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getFechaNac(): ?\DateTimeInterface
    {
        return $this->fecha_nac;
    }

    public function setFechaNac(\DateTimeInterface $fecha_nac): self
    {
        $this->fecha_nac = $fecha_nac;

        return $this;
    }

    public function getidentificacion(): ?string
    {
        return $this->identificacion;
    }

    public function setidentificacion(string $identificacion): self
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function setEdad(?int $edad): self
    {
        $this->edad = $edad;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getTipoid(): ?tipoId
    {
        return $this->tipoid;
    }

    public function setTipoid(?tipoId $tipoid): self
    {
        $this->tipoid = $tipoid;

        return $this;
    }

    public function getFechaCrea(): ?\DateTimeInterface
    {
        return $this->fechaCrea;
    }

    public function setFechaCrea(?\DateTimeInterface $fechaCrea): self
    {
        $this->fechaCrea = $fechaCrea;

        return $this;
    }

    public function getFechaMod(): ?\DateTimeInterface
    {
        return $this->fechaMod;
    }

    public function setFechaMod(?\DateTimeInterface $fechaMod): self
    {
        $this->fechaMod = $fechaMod;

        return $this;
    }

    public function getPreferencias()
    {
        return $this->preferencias;
    }

    public function setPreferencias($preferencias): self
    {
        $this->preferencias = $preferencias;

        return $this;
    }

    /**
     * @return Collection<int, notas>
     */
    public function getNotas(): Collection
    {
        return $this->notas;
    }

    public function addNota(notas $nota): self
    {
        if (!$this->notas->contains($nota)) {
            $this->notas[] = $nota;
            $nota->setEstudiante($this);
        }

        return $this;
    }

    public function removeNota(notas $nota): self
    {
        if ($this->notas->removeElement($nota)) {
            // set the owning side to null (unless already changed)
            if ($nota->getEstudiante() === $this) {
                $nota->setEstudiante(null);
            }
        }

        return $this;
    }
}
