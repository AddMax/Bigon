<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Remove;

use App\Model\Flusher;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserRepository;

class Handler
{
    /**
     * @var \App\Model\User\Entity\UserRepository $users
     */
    private $users;

    /**
     * @var \App\Model\Flusher $flusher
     */
    private $flusher;

    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(User $user): void
    {
        $this->users->remove($user);
        $this->flusher->flush();
    }
}
