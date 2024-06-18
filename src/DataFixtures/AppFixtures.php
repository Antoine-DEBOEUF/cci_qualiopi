<?php

namespace App\DataFixtures;

use App\Entity\InfosUser;
use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Site;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = (new User)
            ->setNom('test')
            ->setPrenom('admin')
            ->setEmail('admin@test.com')
            ->setPassword($this->hasher->hashPassword(new User, 'Test1234!'))
            ->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);

        $user = (new User)
            ->setNom('test')
            ->setPrenom('user')
            ->setEmail('user@test.com')
            ->setPassword($this->hasher->hashPassword(new User, 'Test1234!'))
            ->setRoles(["ROLE_USER"]);

        $manager->persist($user);

        // $user = (new InfosUser)
        //     ->setNom('test')
        //     ->setPrenom('admin');

        // $manager->persist($user);

        // $user = (new InfosUser)
        //     ->setNom('test')
        //     ->setPrenom('user');
        // $manager->persist($user);

        $site = (new Site)
            ->setVille('Lyon')
            ->setCodePostal('69009');

        $manager->persist($site);

        // $module = (new Module)

        //     ->setIntitule('session1')
        //     ->setDateDebut('01/01/2020')
        //     ->setDateFin('01/12/2020');

        // $manager->persist($module);

        // $module = (new Module)
        //     ->setIntitule('session2')
        //     ->setDateDebut('01/02/2020')
        //     ->setDateFin('04/12/2020');

        // $manager->persist($module);

        $manager->flush();
    }
}
