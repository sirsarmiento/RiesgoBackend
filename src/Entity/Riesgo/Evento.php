<?php

namespace App\Entity\Riesgo;

use App\Entity\Empresa;
use App\Entity\User;
use App\Repository\Riesgo\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventoRepository::class)
 */
class Evento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $whereOcurred;

    /**
     * @ORM\Column(type="string", length=2000)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $startTime;

    /**
     * @ORM\Column(type="date")
     */
    private $discoveryDate;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $discoveryTime;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $criticality;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $generateLoss;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $updateBy;

    /**
     * @ORM\ManyToOne(targetEntity=Empresa::class, inversedBy="eventos")
     */
    private $empresa;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="eventos")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Proceso::class, inversedBy="eventos")
     */
    private $procesos;

    /**
     * @ORM\ManyToMany(targetEntity=Control::class, inversedBy="eventos")
     */
    private $controls;

    /**
     * @ORM\ManyToMany(targetEntity=Riesgo::class, inversedBy="eventos")
     */
    private $Riesgos;

    /**
     * @ORM\ManyToMany(targetEntity=CausaConsecuencia::class, inversedBy="eventos")
     */
    private $CausaConsecuencias;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->procesos = new ArrayCollection();
        $this->controls = new ArrayCollection();
        $this->Riesgos = new ArrayCollection();
        $this->CausaConsecuencias = new ArrayCollection();
        $this->createAt = new \DateTime();
        $this->createBy = 'system'; // Default creator
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

    public function getWhereOcurred(): ?string
    {
        return $this->whereOcurred;
    }

    public function setWhereOcurred(string $whereOcurred): self
    {
        $this->whereOcurred = $whereOcurred;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function setStartTime(string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getDiscoveryDate(): ?\DateTimeInterface
    {
        return $this->discoveryDate;
    }

    public function setDiscoveryDate(\DateTimeInterface $discoveryDate): self
    {
        $this->discoveryDate = $discoveryDate;

        return $this;
    }

    public function getDiscoveryTime(): ?string
    {
        return $this->discoveryTime;
    }

    public function setDiscoveryTime(?string $discoveryTime): self
    {
        $this->discoveryTime = $discoveryTime;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCriticality(): ?string
    {
        return $this->criticality;
    }

    public function setCriticality(string $criticality): self
    {
        $this->criticality = $criticality;

        return $this;
    }

    public function getGenerateLoss(): ?string
    {
        return $this->generateLoss;
    }

    public function setGenerateLoss(string $generateLoss): self
    {
        $this->generateLoss = $generateLoss;

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

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

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

    public function getUpdateBy(): ?string
    {
        return $this->updateBy;
    }

    public function setUpdateBy(?string $updateBy): self
    {
        $this->updateBy = $updateBy;

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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);
        return $this;
    }

    /**
     * @return Collection|Proceso[]
     */
    public function getProcesos(): Collection
    {
        return $this->procesos;
    }

    public function addProceso(Proceso $proceso): self
    {
        if (!$this->procesos->contains($proceso)) {
            $this->procesos[] = $proceso;
        }

        return $this;
    }

    public function removeProceso(Proceso $proceso): self
    {
        $this->procesos->removeElement($proceso);

        return $this;
    }

    /**
     * @return Collection|Control[]
     */
    public function getControls(): Collection
    {
        return $this->controls;
    }

    public function addControl(Control $control): self
    {
        if (!$this->controls->contains($control)) {
            $this->controls[] = $control;
        }

        return $this;
    }

    public function removeControl(Control $control): self
    {
        $this->controls->removeElement($control);

        return $this;
    }

    /**
     * @return Collection|Riesgo[]
     */
    public function getRiesgos(): Collection
    {
        return $this->Riesgos;
    }

    public function addRiesgo(Riesgo $riesgo): self
    {
        if (!$this->Riesgos->contains($riesgo)) {
            $this->Riesgos[] = $riesgo;
        }

        return $this;
    }

    public function removeRiesgo(Riesgo $riesgo): self
    {
        $this->Riesgos->removeElement($riesgo);

        return $this;
    }

    /**
     * @return Collection|CausaConsecuencia[]
     */
    public function getCausaConsecuencias(): Collection
    {
        return $this->CausaConsecuencias;
    }

    public function addCausaConsecuencia(CausaConsecuencia $causaConsecuencia): self
    {
        if (!$this->CausaConsecuencias->contains($causaConsecuencia)) {
            $this->CausaConsecuencias[] = $causaConsecuencia;
        }

        return $this;
    }

    public function removeCausaConsecuencia(CausaConsecuencia $causaConsecuencia): self
    {
        $this->CausaConsecuencias->removeElement($causaConsecuencia);

        return $this;
    }
}
