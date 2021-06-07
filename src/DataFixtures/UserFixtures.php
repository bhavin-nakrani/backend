<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Admin User create
        $adminRole = $manager->getRepository('App:Role')->findOneBy(['name' => 'ROLE_ADMIN']);

        $user = new User();
        $user->setName('admin');
        $user->setRoles([$adminRole->getName()]);
        $user->setUserRole($adminRole);
        $user->setEmail('admin@example.com');
        $user->setPhone('1234567890');
        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);
        $manager->persist($user);

        $faker = Faker::create();
        $roles = $manager->getRepository('App:Role')->findAll();
        foreach ($roles as $role) {
            $user = new User();
            $user->setName($faker->name);
            $user->setRoles([$role->getName()]);
            $user->setUserRole($role);
            $user->setEmail($faker->email);
            $user->setPhone($faker->phoneNumber);
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setPassword($password);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RoleFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['user'];
    }

    private function roles()
    {
        return [
            'ROLE_ADMIN',
            'ROLE_USER',
            'ROLE_MAINTAINER',
            'ROLE_STAFF',
        ];
    }
}
