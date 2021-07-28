<?php

namespace App\Model\EducationalProcess\UseCase\SubjectsPlan\Edit;

use Symfony\Component\Validator\Constraints as Assert;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $idPlan;

    /**
     * @Assert\NotBlank()
     */
    public $subjectsPlan;

    public function __construct(EducationalPlan $educationalPlan)
    {
        $this->idPlan = $educationalPlan->getId();

        /** @var \Doctrine\Common\Collections\Collection $subjectsPlan */
        $this->subjectsPlan = $educationalPlan->getSubjectsPlan();
    }
}
