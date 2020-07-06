<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\UserContact;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserContactFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach($this->UserContactData() as [$number, $address_line_1, $address_line_2, $address_line_3, $address_post_code, $user_id])
        {
            $user_id = $manager->getRepository(User::class)->find($user_id);
            $user_contact = new UserContact();
            $user_contact->setNumber($number);
            $user_contact->setAddressLine1($address_line_1);
            $user_contact->setAddressLine2($address_line_2);
            $user_contact->setAddressLine3($address_line_3);
            $user_contact->setAddressPostCode($address_post_code);
            $user_contact->setUser($user_id);
            $manager->persist($user_contact);
        }

        $manager->flush();
    }

    private function UserContactData()
    {
        return [

            ['07787406501', '61 Headley Park Avenue', 'Headley Park', 'Bristol', 'BS137NW', 2],
            ['07775516275', '91 Memorial Road', 'Hanham', 'Bristol', 'BS153JW', 3]

        ];
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }

}
