<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Edit;

use App\Model\Flusher;
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

    public function handle(Command $command): void
    {
        $user = $this->users->get($command->id);

        $user->edit(
            $command->username,
            $command->email
        );

        $this->flusher->flush();
    }
}
