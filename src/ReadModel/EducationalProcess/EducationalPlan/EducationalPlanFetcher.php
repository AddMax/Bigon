<?php

declare(strict_types=1);

namespace App\ReadModel\EducationalProcess\EducationalPlan;

use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use App\ReadModel\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan;

class EducationalPlanFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(EducationalPlan::class);
        $this->paginator = $paginator;
    }

    public function get(string $id): EducationalPlan
    {
        if (!$educationalPlan = $this->repository->find($id)) {
            throw new NotFoundException('EducationalPlan is not found');
        }
        return $educationalPlan;
    }

    /**
     * @param int $page
     * @param int $size
     * @param string $sort
     * @param string $direction
     * @return PaginationInterface
     */
    public function all(int $page, int $size, string $sort, string $direction): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'specialty',
                'qualification',
                'form_education',
                'status'
            )
            ->from('educational_plans');

        if (!\in_array($sort, ['id','specialty', 'qualification'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
