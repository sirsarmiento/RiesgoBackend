<?php

namespace App\Entity\Riesgo;

use App\Repository\Riesgo\ProcesoRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Empresa;
use App\Entity\User;
use App\Entity\Riesgo\Riesgo;
/**
 * @ORM\Entity(repositoryClass=ProcesoRepository::class)
 */
class Proceso
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
    private $category;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $process;

    /**
     * @ORM\ManyToOne(targetEntity=Proyecto::class, inversedBy="procesos")
     */
    private $project;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $unit;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $description;

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
     * @ORM\ManyToOne(targetEntity=Empresa::class, inversedBy="procesos")
     */
    private $empresa;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="procesos")
     * @ORM\JoinTable(name="proceso_user")
     */
    private Collection $users;

    /**
     * @ORM\ManyToMany(targetEntity=Riesgo::class, mappedBy="procesos")
     */
    private Collection $riesgos;

    /**
     * @ORM\ManyToMany(targetEntity=Evento::class, mappedBy="procesos")
     */
    private $eventos;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->riesgos = new ArrayCollection();
        $this->createAt = new \DateTime();
        $this->createBy = 'system'; // Default creator
        $this->updateAt = null; // Initially no updates
        $this->updateBy = null; // Initially no updates
        $this->category = 0; // Default category
        $this->type = 0; // Default type
        $this->eventos = new ArrayCollection();
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

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getProcess(): ?int
    {
        return $this->process;
    }

    public function setProcess(?int $process): self
    {
        $this->process = $process;

        return $this;
    }

    public function getProject(): ?Proyecto
    {
        return $this->project;
    }

    public function setProject(?Proyecto $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getUnit(): ?int
    {
        return $this->unit;
    }

    public function setUnit(?int $unit): self
    {
        $this->unit = $unit;

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

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): self
    {
        $this->empresa = $empresa;

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
            $user->addProceso($this);
        }
        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeProceso($this);
        }
        return $this;
    }

    public function getRiesgos(): Collection
    {
        return $this->riesgos;
    }

    public function addRiesgo(Riesgo $riesgo): self
    {
        if (!$this->riesgos->contains($riesgo)) {
            $this->riesgos[] = $riesgo;
            $riesgo->addProceso($this);
        }
        return $this;
    }

    public function removeRiesgo(Riesgo $riesgo): self
    {
        $this->riesgos->removeElement($riesgo);
        return $this;
    }

    /**
     * @return Collection|Evento[]
     */
    public function getEventos(): Collection
    {
        return $this->eventos;
    }

    public function addEvento(Evento $evento): self
    {
        if (!$this->eventos->contains($evento)) {
            $this->eventos[] = $evento;
            $evento->addProceso($this);
        }

        return $this;
    }

    public function removeEvento(Evento $evento): self
    {
        if ($this->eventos->removeElement($evento)) {
            $evento->removeProceso($this);
        }

        return $this;
    }
}
