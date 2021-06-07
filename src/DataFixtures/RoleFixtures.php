<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->roles() as $roleName) {
            $role = new Role();
            $role->setName($roleName);
            $role->setIsAdd(true);
            $role->setIsEdit(true);
            $role->setIsDelete(true);
            $role->setIsView(true);
            $manager->persist($role);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['role'];
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
