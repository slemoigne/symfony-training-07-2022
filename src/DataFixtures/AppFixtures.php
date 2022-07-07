<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = (new User())
            ->setEmail('admin@sensiotv.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('$2y$13$EudVeKrYO4C.mY0XlAITC.yQnxwUgTD88zrPDZUyKa7e3GAtgRqwC');

        $superAdmin = (new User())
            ->setEmail('superadmin@sensiotv.fr')
            ->setRoles(['ROLE_SUPER_ADMIN'])
            ->setPassword('$2y$13$iQZ8f2eSGacyHHQ4wX8/de3N68QoEbaR1FqkXJLJQxtvPiCXV7sG2');

        $junior = (new User())
            ->setEmail('junior@sensiotv.fr')
            ->setRoles(['ROLE_JUNIOR'])
            ->setPassword('$2y$13$RDXHWQ6ZCHG2sFYRFEKnxujryKX8JhGlswFtVT3RZejxkFODZMmNi');

        $manager->persist($admin);
        $manager->persist($superAdmin);
        $manager->persist($junior);

        $manager->flush();
    }
}
