<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
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
    private string $TaskName;

    /** @var Collection<int, TaskService> */

    #[Groups( ['project'] )]
    #[ORM\OneToMany(mappedBy: 'Task', targetEntity: TaskService::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $TaskService;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'Task')]
    #[ORM\JoinColumn(name: 'Project_UUID', referencedColumnName: 'UUID', nullable: false)]
    private ?Project $Project;

    public function __construct()
    {
        $this->TaskService = new ArrayCollection();
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

    public function getTaskName(): ?string
    {
        return $this->TaskName;
    }

    public function setTaskName(string $TaskName): self
    {
        $this->TaskName = $TaskName;

        return $this;
    }

    /** @return Collection<int, TaskService> */
    public function getTaskService(): Collection
    {
        return $this->TaskService;
    }

    /**
     * @param TaskService $taskService
     * @return Task
     */
    public function addTaskService(TaskService $taskService): self
    {
        dump('SET TS');
        if (!$this->TaskService->contains($taskService)) {
            $this->TaskService[] = $taskService;
            $taskService->setTask($this);
        }

        return $this;
    }

    public function removeTaskService(TaskService $taskService): self
    {
        if ($this->TaskService->removeElement($taskService)) {
            // set the owning side to null (unless already changed)
            if ($taskService->getTask() === $this) {
                $taskService->setTask(null);
            }
        }

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->Project;
    }

    public function setProject(?Project $Project): self
    {
        $this->Project = $Project;

        return $this;
    }
}
