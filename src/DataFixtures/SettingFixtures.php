<?php

namespace App\DataFixtures;

use App\Entity\Setting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SettingFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $role = $manager->getRepository('App:Role')->findOneBy(['name' => 'ROLE_USER']);
        $setting = new Setting();
        $setting->setAppName('Backend');
        $setting->setUserRole($role);
        $setting->setIsArticlePublish(true);
        $setting->setIsLoginUserAuthor(true);
        $setting->setPageSize(10);
        $manager->persist($setting);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['setting'];
    }

    public function getDependencies()
    {
        return [
            RoleFixtures::class,
        ];
    }
}
