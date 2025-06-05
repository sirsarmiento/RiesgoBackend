<?php

namespace App\Entity\Riesgo;

use App\Entity\Empresa;
use App\Repository\Riesgo\ControlRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Riesgo\Riesgo;

/**
 * @ORM\Entity(repositoryClass=ControlRepository::class)
 */
class Control
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
     * @ORM\Column(type="string", length=255)
     */
    private $qualify;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $executionType;

    /**
     * @ORM\Column(type="integer")
     */
    private $isFrequent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $isDocument;

    /**
     * @ORM\Column(type="integer")
     */
    private $hasEvidence;

    /**
     * @ORM\Column(type="integer")
     */
    private $responsibleAssigned;

    /**
     * @ORM\Column(type="integer")
     */
    private $eventsAssociated;

    /**
     * @ORM\Column(type="integer")
     */
    private $isEffective;

    /**
     * @ORM\Column(type="integer")
     */
    private $correctTime;

    /**
     * @ORM\ManyToOne(targetEntity=Empresa::class, inversedBy="controls")
     */
    private $empresa;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

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
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="controls")
     * @ORM\JoinTable(name="control_user")
     */
    private Collection $users;

    /**
     * @ORM\ManyToMany(targetEntity=Riesgo::class, mappedBy="controls")
     */
    private Collection $riesgos;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->riesgos = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQualify(): ?string
    {
        return $this->qualify;
    }

    public function setQualify(string $qualify): self
    {
        $this->qualify = $qualify;

        return $this;
    }

    public function getExecutionType(): ?string
    {
        return $this->executionType;
    }

    public function setExecutionType(string $executionType): self
    {
        $this->executionType = $executionType;

        return $this;
    }

    public function getIsFrequent(): ?int
    {
        return $this->isFrequent;
    }

    public function setIsFrequent(int $isFrequent): self
    {
        $this->isFrequent = $isFrequent;

        return $this;
    }

    public function getIsDocument(): ?string
    {
        return $this->isDocument;
    }

    public function setIsDocument(string $isDocument): self
    {
        $this->isDocument = $isDocument;

        return $this;
    }

    public function getHasEvidence(): ?int
    {
        return $this->hasEvidence;
    }

    public function setHasEvidence(int $hasEvidence): self
    {
        $this->hasEvidence = $hasEvidence;

        return $this;
    }

    public function getResponsibleAssigned(): ?int
    {
        return $this->responsibleAssigned;
    }

    public function setResponsibleAssigned(int $responsibleAssigned): self
    {
        $this->responsibleAssigned = $responsibleAssigned;

        return $this;
    }

    public function getEventsAssociated(): ?int
    {
        return $this->eventsAssociated;
    }

    public function setEventsAssociated(int $eventsAssociated): self
    {
        $this->eventsAssociated = $eventsAssociated;

        return $this;
    }

    public function getIsEffective(): ?int
    {
        return $this->isEffective;
    }

    public function setIsEffective(int $isEffective): self
    {
        $this->isEffective = $isEffective;

        return $this;
    }

    public function getCorrectTime(): ?int
    {
        return $this->correctTime;
    }

    public function setCorrectTime(int $correctTime): self
    {
        $this->correctTime = $correctTime;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
}
