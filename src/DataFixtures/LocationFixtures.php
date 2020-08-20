<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Locations;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $users = $manager->getRepository(User::class)-> findUsers();

        foreach ($users as $user) {

                $location = $user->getAddressTown();

                $locationsStat = new Locations();
                $locationsStat->setLocation($location);
                $locationsStat->setTotalAds(0);
                $locationsStat->setLiveAds(0);
                $manager->persist($locationsStat);
        }

        $manager->flush();
    }

    public function getDependencies()
        {
            return array(
                UserFixtures::class,
            );
        }
}
