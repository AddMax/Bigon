<?php

namespace App\Entity;

use App\Repository\EducationalPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EducationalPlanRepository::class)
 */
class EducationalPlan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $educationalSchedule = [];

    /**
     * @ORM\OneToMany(targetEntity=SubjectsPlan::class, mappedBy="educationalPlan")
     */
    private $subjectsPlan;

    public function __construct()
    {
        $this->subjectsPlan = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEducationalSchedule(): ?array
    {
        return $this->educationalSchedule;
    }

    public function setEducationalSchedule(?array $educationalSchedule): self
    {
        $this->educationalSchedule = $educationalSchedule;

        return $this;
    }

    /**
     * @return Collection|SubjectsPlan[]
     */
    public function getSubjectsPlan(): Collection
    {
        return $this->subjectsPlan;
    }

    public function addSubjectsPlan(SubjectsPlan $subjectsPlan): self
    {
        if (!$this->subjectsPlan->contains($subjectsPlan)) {
            $this->subjectsPlan[] = $subjectsPlan;
            $subjectsPlan->setEducationalPlan($this);
        }

        return $this;
    }

    public function removeSubjectsPlan(SubjectsPlan $subjectsPlan): self
    {
        if ($this->subjectsPlan->removeElement($subjectsPlan)) {
            // set the owning side to null (unless already changed)
            if ($subjectsPlan->getEducationalPlan() === $this) {
                $subjectsPlan->setEducationalPlan(null);
            }
        }

        return $this;
    }
}
