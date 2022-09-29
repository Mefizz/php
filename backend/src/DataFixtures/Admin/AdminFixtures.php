<?php

namespace App\DataFixtures\Admin;

use App\Application\Service\Password\PasswordHasher;
use App\Entity\Admin\Admin;
use App\Entity\Admin\Fields\Email;
use App\Entity\Admin\Fields\Locale;
use App\Entity\Admin\Fields\Name;
use App\Entity\Admin\Fields\Password;
use App\Entity\Admin\Fields\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    public const ADMIN_REFERENCE = 'admin';
    private PasswordHasher $passwordHasher;

    public function __construct(PasswordHasher $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Admin(
            new Email('admin@dare.com'),
            new Password($this->passwordHasher->hash('12345678')),
            new Name('Admin', 'Admin'),
            Locale::en(),
            Status::active()
        );
        $manager->persist($admin);
        $manager->flush();

        $this->addReference(self::ADMIN_REFERENCE, $admin);
    }

}