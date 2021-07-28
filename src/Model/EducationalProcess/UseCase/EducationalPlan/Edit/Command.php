<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\UseCase\EducationalPlan\Edit;

use Symfony\Component\Validator\Constraints as Assert;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $specialty;

    /**
     * @Assert\NotBlank()
     */
    public $direction;

    /**
     * @Assert\NotBlank()
     */
    public $specialization;

    /**
     * @Assert\NotBlank()
     */
    public $qualification;

    /**
     * @Assert\NotBlank()
     */
    public $formEducation;

    /**
     * @Assert\NotBlank()
     */
    public $status;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public static function fromEducationalPlan(EducationalPlan $educationalPlan): self
    {
        $command = new self($educationalPlan->getId());
        $command->specialty = $educationalPlan->getSpecialty();
        $command->direction = $educationalPlan->getDirection() ? $educationalPlan->getDirection() : null;
        $command->specialization = $educationalPlan->getSpecialization() ? $educationalPlan->getSpecialization() :null;
        $command->qualification = $educationalPlan->getQualification() ? $educationalPlan->getQualification() :null;
        $command->formEducation = $educationalPlan->getFormEducation()->getKey();
        $command->status = $educationalPlan->getStatus()->getName();
        return $command;
    }
}
