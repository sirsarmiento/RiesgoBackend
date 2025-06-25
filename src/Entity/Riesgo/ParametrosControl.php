<?php

namespace App\Entity\Riesgo;

use App\Entity\Empresa;
use App\Repository\Riesgo\ParametrosControlRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParametrosControlRepository::class)
 */
class ParametrosControl
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
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $parama;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $paramb;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $paramc;

    /**
     * @ORM\ManyToOne(targetEntity=Empresa::class, inversedBy="parametrosControls")
     */
    private $empresa;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $updateBy;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $module;

    public function __construct()
    {
        $this->createAt = new \DateTime();
        $this->createBy = 'system'; // Default creator, can be changed later
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getParama(): ?string
    {
        return $this->parama;
    }

    public function setParama(string $parama): self
    {
        $this->parama = $parama;

        return $this;
    }

    public function getParamb(): ?string
    {
        return $this->paramb;
    }

    public function setParamb(string $paramb): self
    {
        $this->paramb = $paramb;

        return $this;
    }

    public function getParamc(): ?string
    {
        return $this->paramc;
    }

    public function setParamc(?string $paramc): self
    {
        $this->paramc = $paramc;

        return $this;
    }

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): self
    {
        $this->empresa = $empresa;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getCreateBy(): ?string
    {
        return $this->createBy;
    }

    public function setCreateBy(string $createBy): self
    {
        $this->createBy = $createBy;

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

    public function getModule(): ?string
    {
        return $this->module;
    }

    public function setModule(string $module): self
    {
        $this->module = $module;

        return $this;
    }
}
