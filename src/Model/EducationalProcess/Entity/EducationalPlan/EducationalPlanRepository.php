<?php

declare(strict_types=1);

namespace App\Model\EducationalProcess\Entity\EducationalPlan;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class EducationalPlanRepository
{
    private $em;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(EducationalPlan::class);
    }

    public function get(int $id): EducationalPlan
    {
        if (!$educationalPlan = $this->repo->find($id)) {
            throw new EntityNotFoundException('EducationalPlan is not found.');
        }
        return $educationalPlan;
    }

    public function add(EducationalPlan $educationalPlan): void
    {
        $this->em->persist($educationalPlan);
    }

    public function remove(EducationalPlan $educationalPlan): void
    {
        $this->em->remove($educationalPlan);
    }
}
