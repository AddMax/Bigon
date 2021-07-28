<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\UseCase\EducationalSchedule\Edit;

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
    public $educationalSchedule;

    public function __construct(EducationalPlan $educationalPlan)
    {
        $this->id = $educationalPlan->getId();

        /**
         * @var null|array $educationalSchedule
         */
        $educationalSchedule = $educationalPlan->getEducationalSchedule()->getSchedule();

        $this->educationalSchedule = empty($educationalSchedule) ? $this->emptyDatas() : $educationalSchedule;
    }

    private function emptyDatas()
    {
        $po = [':', '', '=', '//'];

        $week = 52;
        $courses = 4;
        $a = [];
        for ($cours = 1; $cours <= $courses; $cours++) {

            $w = array_map(function ($n, $k) use ($po) {
                return [
                    'week' => $k,
                    'val' => $po[array_rand($po)]
                ];
            }, array_fill(1, $week, ''), array_keys(array_fill(1, $week, '')));

            $a[] = $w;
            // $a[] = [
            //     'cours' => $cours,
            //     'datas' => $w
            // ];
        }
        return $a;
    }

    /**
     * Set json the value of educationalSchedule
     */
    public function setEducationalSchedule(string $educationalSchedule): self
    {
        if ($educationalSchedule === null || $educationalSchedule === '') {
            $this->educationalSchedule = [];
        } else {
            $this->educationalSchedule = json_decode($educationalSchedule, true);
        }
        return $this;
    }

    /**
     * Get the value of educationalSchedule
     */
    public function getEducationalSchedule()
    {
        return json_encode($this->educationalSchedule, 15);
    }
}
