<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un compte ADMIN de test
        $user = new User();
        $user->setEmail('test@test.com');
        $user->setRoles(['ROLE_ADMIN']);
        
        // On crypte le mot de passe "test123"
        $password = $this->hasher->hashPassword($user, 'test123');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}