<?php

namespace App\Entity\Riesgo;

use App\Entity\Empresa;
use App\Repository\Riesgo\RiesgoRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Riesgo\Proceso;
use App\Entity\User;
use App\Entity\Riesgo\CausaConsecuencia;

/**
 * @ORM\Entity(repositoryClass=RiesgoRepository::class)
 */
class Riesgo
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
     * @ORM\Column(type="integer")
     */
    private $impacto;

    /**
     * @ORM\Column(type="integer")
     */
    private $frecuencia;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $affect;

    /**
     * @ORM\ManyToOne(targetEntity=Empresa::class, inversedBy="Riesgo")
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
     * @ORM\ManyToMany(targetEntity=Proceso::class, inversedBy="riesgos")
     * @ORM\JoinTable(name="riesgo_proceso")
     */
    private Collection $procesos;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="riesgos")
     * @ORM\JoinTable(name="riesgo_user")
     */
    private Collection $users;

    /**
     * @ORM\ManyToMany(targetEntity=CausaConsecuencia::class, inversedBy="riesgos")
     * @ORM\JoinTable(name="riesgo_causa_consecuencia")
     */
    private Collection $causaConsecuencias;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->procesos = new ArrayCollection();
        $this->causaConsecuencias = new ArrayCollection();
        $this->createAt = new \DateTime();
        $this->createBy = 'System'; // Default value, can be changed later
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

    public function getImpacto(): ?int
    {
        return $this->impacto;
    }

    public function setImpacto(int $impacto): self
    {
        $this->impacto = $impacto;

        return $this;
    }

    public function getFrecuencia(): ?int
    {
        return $this->frecuencia;
    }

    public function setFrecuencia(int $frecuencia): self
    {
        $this->frecuencia = $frecuencia;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAffect(): ?bool
    {
        return $this->affect;
    }

    public function setAffect(bool $affect): self
    {
        $this->affect = $affect;

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

    public function getProcesos(): Collection
    {
        return $this->procesos;
    }

    public function addProceso(Proceso $proceso): self
    {
        if (!$this->procesos->contains($proceso)) {
            $this->procesos[] = $proceso;
            $proceso->addRiesgo($this);
        }
        return $this;
    }

    public function removeProceso(Proceso $proceso): self
    {
        if ($this->procesos->removeElement($proceso)) {
            $proceso->removeRiesgo($this);
        }
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addRiesgo($this);
        }
        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeRiesgo($this);
        }
        return $this;
    }

    public function getCausaConsecuencias(): Collection
    {
        return $this->causaConsecuencias;
    }

    public function addCausaConsecuencia(CausaConsecuencia $causaConsecuencia): self
    {
        if (!$this->causaConsecuencias->contains($causaConsecuencia)) {
            $this->causaConsecuencias[] = $causaConsecuencia;
            $causaConsecuencia->addRiesgo($this);
        }
        return $this;
    }

    public function removeCausaConsecuencia(CausaConsecuencia $causaConsecuencia): self
    {
        if ($this->causaConsecuencias->removeElement($causaConsecuencia)) {
            $causaConsecuencia->removeRiesgo($this);
        }
        return $this;
    }
}
