<?php

namespace App\Entity\Riesgo;

use App\Repository\Riesgo\ImpactoFrecuenciaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImpactoFrecuenciaRepository::class)
 */
class ImpactoFrecuencia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Impacto::class, inversedBy="impactoFrecuencias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $impacto;

    /**
     * @ORM\ManyToOne(targetEntity=Frecuencia::class, inversedBy="impactoFrecuencias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $frecuencia;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $color;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $updateBy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImpacto(): ?Impacto
    {
        return $this->impacto;
    }

    public function setImpacto(?Impacto $impacto): self
    {
        $this->impacto = $impacto;

        return $this;
    }

    public function getFrecuencia(): ?Frecuencia
    {
        return $this->frecuencia;
    }

    public function setFrecuencia(?Frecuencia $frecuencia): self
    {
        $this->frecuencia = $frecuencia;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getUpdateBy(): ?string
    {
        return $this->updateBy;
    }

    public function setUpdateBy(?string $updateBy): self
    {
        $this->updateBy = $updateBy;

        return $this;
    }
}
