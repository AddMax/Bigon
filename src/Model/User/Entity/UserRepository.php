<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository
{
    private $em;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(User::class);
    }

    public function get(int $id): User
    {
        /** @var User $user */
        if (!$user = $this->repo->find($id)) {
            throw new EntityNotFoundException('User is not found.');
        }
        return $user;
    }

    public function getByUsername(string $username): User
    {
        /** @var User $user */
        if (!$user = $this->repo->findOneBy(['username' => $username])) {
            throw new EntityNotFoundException('User is not found.');
        }
        return $user;
    }

    public function hasByUsername(string $username): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.username = :username')
                ->setParameter(':username', $username)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
    }
}
