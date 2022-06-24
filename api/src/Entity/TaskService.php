<?php

namespace App\Entity;

use App\Repository\TaskServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TaskServiceRepository::class)]
class TaskService
{
    #[Groups( ['project'] )]
    #[
        ORM\Id,
        ORM\Column(name: 'UUID', type:"uuid", unique:true),
        ORM\GeneratedValue(strategy: 'CUSTOM'),
        ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')
    ]
    private Uuid $UUID;

    #[Groups( ['project'] )]
    #[ORM\Column(type: 'string', length: 255)]
    private string $TaskServiceName;

    /** @var  Collection<int, TaskServicePeriodPlan> */
    #[Groups( ['project'] )]
    #[ORM\OneToMany(mappedBy: 'TaskService', targetEntity: TaskServicePeriodPlan::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $TaskServicePeriodPlan;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: 'TaskService')]
    #[ORM\JoinColumn(name: 'Task_UUID', referencedColumnName: 'UUID', nullable: false)]
    private ?Task $Task;

    public function __construct()
    {
        $this->TaskServicePeriodPlan = new ArrayCollection();
    }

    public function getUUID(): ?Uuid
    {
        return $this->UUID;
    }

    public function setUUID(string $uuid): self
    {
        $this->UUID = Uuid::fromString($uuid);

        return $this;
    }

    public function getTaskServiceName(): ?string
    {
        return $this->TaskServiceName;
    }

    public function setTaskServiceName(string $TaskServiceName): self
    {
        $this->TaskServiceName = $TaskServiceName;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->Task;
    }

    public function setTask(?Task $Task): self
    {
        $this->Task = $Task;

        return $this;
    }

    /** @return Collection<int, TaskServicePeriodPlan> */
    public function getTaskServicePeriodPlan(): Collection
    {
        return $this->TaskServicePeriodPlan;
    }

    public function addTaskServicePeriodPlan(TaskServicePeriodPlan $taskServicePeriodPlan): self
    {
        if (!$this->TaskServicePeriodPlan->contains($taskServicePeriodPlan)) {
            $this->TaskServicePeriodPlan[] = $taskServicePeriodPlan;
            $taskServicePeriodPlan->setTaskService($this);
        }

        return $this;
    }

    public function removeTaskServicePeriodPlan(TaskServicePeriodPlan $taskServicePeriodPlan): self
    {
        if ($this->TaskServicePeriodPlan->removeElement($taskServicePeriodPlan)) {
            // set the owning side to null (unless already changed)
            if ($taskServicePeriodPlan->getTaskService() === $this) {
                $taskServicePeriodPlan->setTaskService(null);
            }
        }

        return $this;
    }
}
