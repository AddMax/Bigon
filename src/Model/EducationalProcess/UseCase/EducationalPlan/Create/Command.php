<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\UseCase\EducationalPlan\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
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

}
