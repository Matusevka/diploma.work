<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    private $em;
    
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $this->encoder = $encoder;
        $this->em = $entityManager;
    }
    
    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $usersData = [
              0 => [
                  'email' => 'user@example.com',
                  'role' => ['ROLE_USER'],
                  'password' => 123654,
                  'name' => 'Пользователь'
              ]
        ];

        foreach ($usersData as $user) {
            $newUser = new User();
            $newUser->setEmail($user['email']);
            $newUser->setPassword($this->encoder->encodePassword($newUser, $user['password']));
            $newUser->setRoles($user['role']);
            $newUser->setName($user['name']);
            $this->em->persist($newUser);
        }

        $this->em->flush();
    }
}
