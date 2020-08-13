<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach($this->getUserData() as [$name, $last_name, $email, $password, $roles, $number, $address_line_1, $address_line_2, $address_line_3, $address_town, $address_county, $address_post_code, $total_free_ads])
        {
            $user = new User();
            $user->setName($name);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setPassword($this->password_encoder->encodePassword($user, $password));
            $user->setRoles($roles);
            $user->setNumber($number);
            $user->setAddressLine1($address_line_1);
            $user->setAddressLine2($address_line_2);
            $user->setAddressLine3($address_line_3);
            $user->setAddressTown($address_town);
            $user->setAddressCounty($address_county);
            $user->setAddressPostCode($address_post_code);
            $user->setTotalFreeAds($total_free_ads);
            $user->setStartDate(new \DateTime());
            $user->setStartTime(new \DateTime());
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            ['Paul', 'Robson', 'blakepablo24@gmail.com', '12345', ['ROLE_ADMIN'], '', '', '', '', '', '', '', 0],
            ['Claire', 'Harvey', 'ionaharvey89@outlook.com', '12345', ['ROLE_USER'], '07787406501', '61 Headley Park Avenue', 'Headley Park', '', 'Bristol', 'Avon', 'BS137NW', 15],
            ['Lucky', 'Singh', 'lionsingh89@hotmail.com', '12345', ['ROLE_USER'], '07775516275', '56 Buccleuch Road', '', '', 'Selkirk', '', 'TD75DN', 18]
        ];

    }
}
