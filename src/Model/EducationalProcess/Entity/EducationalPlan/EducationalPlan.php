<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\Entity\EducationalPlan;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Model\EducationalProcess\Entity\SubjectsPlan\SubjectsPlan;
use App\Model\EducationalProcess\Entity\EducationalSchedule\EducationalSchedule;

/**
 * @ORM\Entity
 * @ORM\Table(name="educational_plans")
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
     * @ORM\Column(type="string", length=255)
     */
    private $specialty;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $direction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialization;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $qualification;

    /**
     * @var FormEducation
     *  @ORM\Column(type="educational_process_plan_forma", length=255)
     */
    private $formEducation;

    /**
     * @var EducationalSchedule
     * @ORM\Embedded(class="App\Model\EducationalProcess\Entity\EducationalSchedule\EducationalSchedule", columnPrefix = false)
     */
    private $educationalSchedule;

    /**
     * @ORM\OneToMany(targetEntity=App\Model\EducationalProcess\Entity\SubjectsPlan\SubjectsPlan::class, mappedBy="educationalPlan", orphanRemoval=true, cascade={"persist"})
     */
    private $subjectsPlan;

    /**
     * @var Status
     * @ORM\Column(type="educational_process_plan_status", length=255)
     */
    private $status;

    public function __construct()
    {
        $this->subjectsPlan = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialty(): ?string
    {
        return $this->specialty;
    }

    public function setSpecialty(string $specialty): self
    {
        $this->specialty = $specialty;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): self
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): self
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getFormEducation(): ?FormEducation
    {
        return $this->formEducation;
    }

    public function setFormEducation(FormEducation $formEducation): self
    {
        $this->formEducation = $formEducation;

        return $this;
    }

    public function getEducationalSchedule(): EducationalSchedule
    {
        return $this->educationalSchedule;
    }

    public function setEducationalSchedule(EducationalSchedule $educationalSchedule): self
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

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }
}
