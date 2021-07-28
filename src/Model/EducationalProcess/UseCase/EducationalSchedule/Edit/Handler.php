<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\UseCase\EducationalSchedule\Edit;

use App\Model\Flusher;
use App\Model\EducationalProcess\Entity\EducationalPlan\Status;
use App\Model\EducationalProcess\Entity\EducationalPlan\FormEducation;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan;
use App\Model\EducationalProcess\Entity\EducationalSchedule\EducationalSchedule;
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

    public function handle(Command $command): void
    {
        $schedule = new EducationalSchedule();
        $schedule->setSchedule($command->educationalSchedule);
        
        $educationalPlan = $this->educationalPlan->get($command->id);
        $educationalPlan->setEducationalSchedule($schedule);

        $this->educationalPlan->add($educationalPlan);

        $this->flusher->flush();
    }
}
