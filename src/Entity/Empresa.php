<?php

namespace App\Entity;

use App\Entity\Riesgo\CausaConsecuencia;
use App\Entity\Riesgo\Control;
use App\Entity\Riesgo\Evento;
use App\Entity\Riesgo\ParametrosControl;
use App\Entity\Riesgo\Proceso;
use App\Entity\Riesgo\Proyecto;
use App\Entity\Riesgo\Riesgo;
use App\Entity\Status;
use App\Repository\EmpresaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpresaRepository::class)
 */
class Empresa
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
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="empresastatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\Column(type="string", length=1000)
     */
    private $url_logo;

    /**
     * @ORM\OneToMany(targetEntity=Proyecto::class, mappedBy="empresa")
     */
    private $proyectos;

    /**
     * @ORM\OneToMany(targetEntity=Proceso::class, mappedBy="empresa")
     */
    private $procesos;

    /**
     * @ORM\OneToMany(targetEntity=Riesgo::class, mappedBy="empresa")
     */
    private $Riesgo;

    /**
     * @ORM\OneToMany(targetEntity=CausaConsecuencia::class, mappedBy="empresa")
     */
    private $causaConsecuencias;

    /**
     * @ORM\OneToMany(targetEntity=Control::class, mappedBy="empresa")
     */
    private $controls;

    /**
     * @ORM\OneToMany(targetEntity=ParametrosControl::class, mappedBy="empresa")
     */
    private $parametrosControls;

    /**
     * @ORM\OneToMany(targetEntity=Evento::class, mappedBy="empresa")
     */
    private $eventos;


    public function __construct()
    {
        $this->proyectos = new ArrayCollection();
        $this->procesos = new ArrayCollection();
        $this->Riesgo = new ArrayCollection();
        $this->causaConsecuencias = new ArrayCollection();
        $this->controls = new ArrayCollection();
        $this->parametrosControls = new ArrayCollection();
        $this->eventos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(?\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getCreateBy(): ?string
    {
        return $this->createBy;
    }

    public function setCreateBy(?string $createBy): self
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
    
    public function getUrlLogo(): ?string
    {
        return $this->url_logo;
    }

    public function setUrlLogo(string $url_logo): self
    {
        $this->url_logo = $url_logo;

        return $this;
    }

    /**
     * @return Collection|Proyecto[]
     */
    public function getProyectos(): Collection
    {
        return $this->proyectos;
    }

    public function addProyecto(Proyecto $proyecto): self
    {
        if (!$this->proyectos->contains($proyecto)) {
            $this->proyectos[] = $proyecto;
            $proyecto->setEmpresa($this);
        }

        return $this;
    }

    public function removeProyecto(Proyecto $proyecto): self
    {
        if ($this->proyectos->removeElement($proyecto)) {
            // set the owning side to null (unless already changed)
            if ($proyecto->getEmpresa() === $this) {
                $proyecto->setEmpresa(null);
            }
        }

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
            $proceso->setEmpresa($this);
        }

        return $this;
    }

    public function removeProceso(Proceso $proceso): self
    {
        if ($this->procesos->removeElement($proceso)) {
            // set the owning side to null (unless already changed)
            if ($proceso->getEmpresa() === $this) {
                $proceso->setEmpresa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Riesgo[]
     */
    public function getRiesgo(): Collection
    {
        return $this->Riesgo;
    }

    public function addRiesgo(Riesgo $riesgo): self
    {
        if (!$this->Riesgo->contains($riesgo)) {
            $this->Riesgo[] = $riesgo;
            $riesgo->setEmpresa($this);
        }

        return $this;
    }

    public function removeRiesgo(Riesgo $riesgo): self
    {
        if ($this->Riesgo->removeElement($riesgo)) {
            // set the owning side to null (unless already changed)
            if ($riesgo->getEmpresa() === $this) {
                $riesgo->setEmpresa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CausaConsecuencia[]
     */
    public function getCausaConsecuencias(): Collection
    {
        return $this->causaConsecuencias;
    }

    public function addCausaConsecuencia(CausaConsecuencia $causaConsecuencia): self
    {
        if (!$this->causaConsecuencias->contains($causaConsecuencia)) {
            $this->causaConsecuencias[] = $causaConsecuencia;
            $causaConsecuencia->setEmpresa($this);
        }

        return $this;
    }

    public function removeCausaConsecuencia(CausaConsecuencia $causaConsecuencia): self
    {
        if ($this->causaConsecuencias->removeElement($causaConsecuencia)) {
            // set the owning side to null (unless already changed)
            if ($causaConsecuencia->getEmpresa() === $this) {
                $causaConsecuencia->setEmpresa(null);
            }
        }

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
            $control->setEmpresa($this);
        }

        return $this;
    }

    public function removeControl(Control $control): self
    {
        if ($this->controls->removeElement($control)) {
            // set the owning side to null (unless already changed)
            if ($control->getEmpresa() === $this) {
                $control->setEmpresa(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ParametrosControl[]
     */
    public function getParametrosControls(): Collection
    {
        return $this->parametrosControls;
    }

    public function addParametrosControl(ParametrosControl $parametrosControl): self
    {
        if (!$this->parametrosControls->contains($parametrosControl)) {
            $this->parametrosControls[] = $parametrosControl;
            $parametrosControl->setEmpresa($this);
        }

        return $this;
    }

    public function removeParametrosControl(ParametrosControl $parametrosControl): self
    {
        if ($this->parametrosControls->removeElement($parametrosControl)) {
            // set the owning side to null (unless already changed)
            if ($parametrosControl->getEmpresa() === $this) {
                $parametrosControl->setEmpresa(null);
            }
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
            $evento->setEmpresa($this);
        }

        return $this;
    }

    public function removeEvento(Evento $evento): self
    {
        if ($this->eventos->removeElement($evento)) {
            // set the owning side to null (unless already changed)
            if ($evento->getEmpresa() === $this) {
                $evento->setEmpresa(null);
            }
        }

        return $this;
    }

}
