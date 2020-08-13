<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\FreeItem;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FreeItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach($this->FreeItemData() as [$title, $description, $user_id, $category_id])
        {
            $category = $manager->getRepository(Category::class)->find($category_id);
            $user_id = $manager->getRepository(User::class)->find($user_id);
            $location = $user_id->getAddressTown();
            $free_item = new FreeItem();
            $free_item->setTitle($title);
            $free_item->setDescription($description);
            $free_item->setCategory($category);
            $free_item->setLocation($location);
            $free_item->setState('Draft');
            $free_item->setUser($user_id);
            $free_item->setDate(new \DateTime());
            $free_item->setTime(new \DateTime());
            $manager->persist($free_item);
        }

        $manager->flush();
    }

    private function FreeItemData()
    {
        return [

            ['Single Bed', 'blah blah blah', 2, 1],
            ['Wardrobe', 'blah blah blah', 2, 1],
            ['Chest of Draws', 'blah blah blah', 2, 1],

            ['Compost', 'blah blah blah', 2, 2],
            ['Green House', 'blah blah blah', 2, 2],
            ['Shed', 'blah blah blah', 2, 2],

            ['Lego', 'blah blah blah', 2, 3],
            ['Board games', 'blah blah blah', 2, 3],
            ['Action Fugures', 'blah blah blah', 2, 3],

            ['Boxing Stuff', 'blah blah blah', 2, 4],
            ['Bicycle', 'blah blah blah', 2, 4],
            ['Weights Bench', 'blah blah blah', 2, 4],

            ['DVD Player', 'blah blah blah', 2, 5],
            ['Stereo', 'blah blah blah', 2, 5],
            ['AV Receiver', 'blah blah blah', 2, 5],

            ['Blu Rays', 'blah blah blah', 3, 6],
            ['Cds', 'blah blah blah', 3, 6],
            ['Books', 'blah blah blah', 3, 6],

            ['Collectables', 'blah blah blah', 3, 7],
            ['Porcelain', 'blah blah blah', 3, 7],
            ['Garage Door', 'blah blah blah', 3, 7],

            ['Cheese', 'blah blah blah', 3, 8],
            ['Chocolate', 'blah blah blah', 3, 8],
            ['Tins of Beans', 'blah blah blah', 3, 8],

            ['Roof Rack', 'blah blah blah', 3, 9],
            ['Corsa Bumper', 'blah blah blah', 3, 9],
            ['Windcreen Wipers', 'blah blah blah', 3, 9],

            ['Work Bench', 'blah blah blah', 3, 10],
            ['Tool Box', 'blah blah blah', 3, 10],
            ['Old Hammers', 'blah blah blah', 3, 10],

            ['Jiffy Bags', 'blah blah blah', 3, 11],
            ['Bubble Wrap', 'blah blah blah', 3, 11],
            ['Very Bags', 'blah blah blah', 3, 11]

        ];
    }

    public function getDependencies()
        {
            return array(
                UserFixtures::class,
            );
        }

}
