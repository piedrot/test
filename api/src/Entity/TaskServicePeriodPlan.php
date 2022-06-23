<?php

namespace App\Entity;

use App\Repository\TaskServicePeriodPlanRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TaskServicePeriodPlanRepository::class)]
class TaskServicePeriodPlan
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
    private string $TaskServicePeriodPlanName;

    #[ORM\ManyToOne(targetEntity: TaskService::class, inversedBy: 'TaskServicePeriodPlan')]
    #[ORM\JoinColumn(name: 'TaskService_UUID', referencedColumnName: 'UUID', nullable: false)]
    private TaskService $TaskService;

    public function getUUID(): ?Uuid
    {
        return $this->UUID;
    }

    public function setUUID(string $uuid): self
    {
        $this->UUID = Uuid::fromString($uuid);

        return $this;
    }

    public function getTaskServicePeriodPlanName(): ?string
    {
        return $this->TaskServicePeriodPlanName;
    }

    public function setTaskServicePeriodPlanName(string $TaskServicePeriodPlanName): self
    {
        $this->TaskServicePeriodPlanName = $TaskServicePeriodPlanName;

        return $this;
    }

    public function getTaskService(): ?TaskService
    {
        return $this->TaskService;
    }

    public function setTaskService(?TaskService $TaskService): self
    {
        $this->TaskService = $TaskService;

        return $this;
    }
}
