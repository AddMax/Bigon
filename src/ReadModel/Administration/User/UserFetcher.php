<?php

declare(strict_types=1);

namespace App\ReadModel\Administration\User;

use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use App\Model\User\Entity\User;
use App\ReadModel\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

class UserFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(Connection $connection, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(User::class);
        $this->paginator = $paginator;
    }

    public function get(string $id): User
    {
        if (!$user = $this->repository->find($id)) {
            throw new NotFoundException('User is not found');
        }
        return $user;
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
                'username AS name',
                'email',
                'roles',
            )
            ->from('user_users');

        if (!\in_array($sort, ['id','name', 'email', 'roles'], true)) {
            throw new \UnexpectedValueException('Cannot sort by ' . $sort);
        }

        $qb->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');

        return $this->paginator->paginate($qb, $page, $size);
    }
}
