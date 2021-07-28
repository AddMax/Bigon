<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Create;

use App\Model\Flusher;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Handler
{
    private $users;
    private $passwordEncoder;
    private $flusher;

    public function __construct(
        UserRepository $users,
        UserPasswordEncoderInterface $passwordEncoder,
        Flusher $flusher
    )
    {
        $this->users = $users;
        $this->passwordEncoder = $passwordEncoder;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if ($this->users->hasByUsername($command->username)) {
            throw new \DomainException('Учетная запись с таким именем существует.');
        }

        $user = User::create(
            $command->username,
            $command->email
        );
        $passwordHash = $this->passwordEncoder->encodePassword($user, $command->password);
        $user->setPassword($passwordHash);

        $this->users->add($user);

        $this->flusher->flush();
    }
}
