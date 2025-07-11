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
use App\Entity\Riesgo\Control;
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

    /**
     * @ORM\ManyToMany(targetEntity=Control::class, inversedBy="riesgos")
     * @ORM\JoinTable(name="riesgo_control")
     */
    private Collection $controls;

    /**
     * @ORM\ManyToOne(targetEntity=Impacto::class, inversedBy="riesgos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $impact;

    /**
     * @ORM\ManyToOne(targetEntity=Frecuencia::class, inversedBy="riesgos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $frequency;

    /**
     * @ORM\ManyToMany(targetEntity=Evento::class, mappedBy="Riesgos")
     */
    private $eventos;

    /**
     * @ORM\ManyToMany(targetEntity=Plan::class, mappedBy="riesgos")
     */
    private $plans;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->procesos = new ArrayCollection();
        $this->causaConsecuencias = new ArrayCollection();
        $this->controls = new ArrayCollection();
        $this->createAt = new \DateTime();
        $this->createBy = 'System'; // Default value, can be changed later
        $this->eventos = new ArrayCollection();
        $this->plans = new ArrayCollection();
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

    public function getImpact(): ?Impacto
    {
        return $this->impact;
    }

    public function setImpact(?Impacto $impact): self
    {
        $this->impact = $impact;

        return $this;
    }

    public function getFrequency(): ?Frecuencia
    {
        return $this->frequency;
    }

    public function setFrequency(?Frecuencia $frequency): self
    {
        $this->frequency = $frequency;

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

    public function getControls(): Collection
    {
        return $this->controls;
    }

    public function addControl(Control $control): self
    {
        if (!$this->controls->contains($control)) {
            $this->controls[] = $control;
            $control->addRiesgo($this);
        }
        return $this;
    }

    public function removeControl(Control $control): self
    {
        if ($this->controls->removeElement($control)) {
            $control->removeRiesgo($this);
        }
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
            $evento->addRiesgo($this);
        }

        return $this;
    }

    public function removeEvento(Evento $evento): self
    {
        if ($this->eventos->removeElement($evento)) {
            $evento->removeRiesgo($this);
        }

        return $this;
    }

    /**
     * @return Collection|Plan[]
     */
    public function getPlans(): Collection
    {
        return $this->plans;
    }

    public function addPlan(Plan $plan): self
    {
        if (!$this->plans->contains($plan)) {
            $this->plans[] = $plan;
            $plan->addRiesgo($this);
        }

        return $this;
    }

    public function removePlan(Plan $plan): self
    {
        if ($this->plans->removeElement($plan)) {
            $plan->removeRiesgo($this);
        }

        return $this;
    }
}
