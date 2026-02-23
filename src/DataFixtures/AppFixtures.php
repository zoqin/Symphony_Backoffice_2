<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use App\Enum\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // 1. Création d'un Admin
        $admin = new User();
        $admin->setEmail('admin@test.com')
            ->setFirstname('Jean')
            ->setLastname('Admin')
            ->addRole(UserRole::ADMIN)
            ->setPassword($this->hasher->hashPassword($admin, 'password'));
        $manager->persist($admin);

        // 2. Création d'un Manager
        $managerUser = new User();
        $managerUser->setEmail('manager@test.com')
            ->setFirstname('Sophie')
            ->setLastname('Manager')
            ->addRole(UserRole::MANAGER)
            ->setPassword($this->hasher->hashPassword($managerUser, 'password'));
        $manager->persist($managerUser);

        // 3. Création d'un Utilisateur standard
        $user = new User();
        $user->setEmail('user@test.com')
            ->setFirstname('Lucas')
            ->setLastname('User')
            ->addRole(UserRole::USER)
            ->setPassword($this->hasher->hashPassword($user, 'password'));
        $manager->persist($user);

        $productNames = [
            'Mercer Sphere',
            'Somersloop',
            'AI Limiter',
            'Alclad Aluminum Sheet',
            'Aluminum Casing',
            'Biomass',
            'Cable',
            'Circuit Board'

        ];

        foreach ($productNames as $name) {
            $product = new Product();
            $product->setName($name)
                ->setDescription('Description très cool de '.$name.' meilleur produit certifié ficsit')
                ->setPrice((string) (mt_rand(1000, 100000))/100);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
