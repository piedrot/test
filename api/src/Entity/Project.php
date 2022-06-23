<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[Groups( ['project'] )]
    #[
        ORM\Id,
        ORM\Column(name: 'UUID', type:"uuid", unique:true),
        ORM\GeneratedValue(strategy: 'CUSTOM'),
        ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')
    ]
    private $UUID;

    #[Groups( ['project'] )]
    #[ORM\Column(type: 'string', length: 255)]
    private string $ProjectName;

    #[Groups( ['project'] )]
    #[ORM\OneToMany(mappedBy: 'Project', targetEntity: Task::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $Task;

    public function __construct()
    {
        $this->Task = new ArrayCollection();
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

    public function getProjectName(): ?string
    {
        return $this->ProjectName;
    }

    public function setProjectName(string $Name): self
    {
        $this->ProjectName = $Name;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTask(): Collection
    {
        return $this->Task;
    }

    public function addTask(Task $task): self
    {
        if (!$this->Task->contains($task)) {
            $this->Task[] = $task;
            $task->setProject($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->Task->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }

        return $this;
    }
}
