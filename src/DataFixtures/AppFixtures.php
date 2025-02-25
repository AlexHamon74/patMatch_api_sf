<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function __construct() {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // ---------------
        // Ajout des Users
        // ---------------
        $admin_user = new User();
        $admin_user->setEmail('admin@test.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('admin123')
            ->setNom('Test')
            ->setPrenom('Admin')
            ->setDateDeNaissance(new DateTimeImmutable())
            ->setMisAJourLe(new DateTimeImmutable());
        $manager->persist($admin_user);

        $eleveur_user = new User();
        $eleveur_user->setEmail('eleveur@test.com')
            ->setRoles(['ROLE_ELEVEUR'])
            ->setPassword('eleveur123')
            ->setNom('Test')
            ->setPrenom('Eleveur')
            ->setDateDeNaissance(new DateTimeImmutable())
            ->setMisAJourLe(new DateTimeImmutable());
        $manager->persist($eleveur_user);

        $particulier_user = new User();
        $particulier_user->setEmail('particulier@test.com')
            ->setRoles(['ROLE_PARTICULIER'])
            ->setPassword('part123')
            ->setNom('Test')
            ->setPrenom('Particulier')
            ->setDateDeNaissance(new DateTimeImmutable())
            ->setMisAJourLe(new DateTimeImmutable());
        $manager->persist($particulier_user);


        $manager->flush();
    }
}
