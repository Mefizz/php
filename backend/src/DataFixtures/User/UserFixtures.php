<?php

namespace App\DataFixtures\User;

use App\Application\Service\Password\PasswordHasher;
use App\Entity\User\Fields\{Apple, Email, Facebook, Locale, Balance, Password, PushNotification, Status};
use App\Entity\User\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';

    private PasswordHasher $passwordHasher;

    public function __construct(PasswordHasher $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User(
            new Balance('Alex', 'Dowis'),
            new Email('test@test.com'),
            new Password($this->passwordHasher->hash('12345678')),
            new Facebook(),
            new Apple(),
            Locale::en(),
            PushNotification::yes(),
            new DateTimeImmutable(),
            Status::active()
        );

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::USER_REFERENCE, $user);
    }
}
