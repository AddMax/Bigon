<?php

namespace App\Model\EducationalProcess\Entity\SubjectsPlan;

use Doctrine\ORM\Mapping as ORM;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan;

/**
 * @ORM\Entity
 * @ORM\Table(name="educational_subjects_plan")
 */
class SubjectsPlan
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lecture;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $distribution = [];

    /**
     * @ORM\ManyToOne(targetEntity=App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan::class, inversedBy="subjectsPlan")
     * @ORM\JoinColumn(name="educational_plan_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $educationalPlan;

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

    public function getLecture(): ?int
    {
        return $this->lecture;
    }

    public function setLecture(?int $lecture): self
    {
        $this->lecture = $lecture;

        return $this;
    }

    public function getDistribution(): ?array
    {
        return $this->distribution;
    }

    public function setDistribution(?array $distribution): self
    {
        $this->distribution = $distribution;

        return $this;
    }

    public function getEducationalPlan(): ?EducationalPlan
    {
        return $this->educationalPlan;
    }

    public function setEducationalPlan(?EducationalPlan $educationalPlan): self
    {
        $this->educationalPlan = $educationalPlan;

        return $this;
    }
}
