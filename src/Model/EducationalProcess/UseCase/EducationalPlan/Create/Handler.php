<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\UseCase\EducationalPlan\Create;

use App\Model\Flusher;
use App\Model\EducationalProcess\Entity\EducationalPlan\Status;
use App\Model\EducationalProcess\Entity\EducationalPlan\FormEducation;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlanRepository;

class Handler
{
    private $educationalPlan;
    private $flusher;

    public function __construct(
        EducationalPlanRepository $educationalPlan,
        Flusher $flusher
    )
    {
        $this->educationalPlan = $educationalPlan;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): EducationalPlan
    {
        $educationalPlan = new EducationalPlan();
        $educationalPlan->setSpecialty($command->specialty);
        $educationalPlan->setDirection($command->direction);
        $educationalPlan->setSpecialization($command->specialization);
        $educationalPlan->setQualification($command->qualification);
        $educationalPlan->setFormEducation(new FormEducation($command->formEducation));
        $educationalPlan->setStatus(Status::active());

        $this->educationalPlan->add($educationalPlan);

        $this->flusher->flush();

        return $educationalPlan;
    }
}
