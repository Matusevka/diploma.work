<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
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
        $adminsData = [
              0 => [
                  'email' => 'admin@example.com',
                  'role' => ['ROLE_ADMIN'],
                  'password' => 123654,
                  'name' => 'Админ'
              ]
        ];

        foreach ($adminsData as $admin) {
            $newAdmin = new User();
            $newAdmin->setEmail($admin['email']);
            $newAdmin->setPassword($this->encoder->encodePassword($newAdmin, $admin['password']));
            $newAdmin->setRoles($admin['role']);
            $newAdmin->setName($admin['name']);
            $this->em->persist($newAdmin);
        }

        $this->em->flush();
    }
}
