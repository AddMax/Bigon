<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\Entity\EducationalSchedule;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class EducationalSchedule
{

    /**
     * @ORM\Column(type="array", name="educational_schedule", nullable=true)
     */
    private $schedule = [];

    public function getSchedule(): ?array
    {
        return $this->schedule;
    }

    public function setSchedule(?array $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }
}
