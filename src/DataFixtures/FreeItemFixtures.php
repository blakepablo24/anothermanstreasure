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
        foreach($this->FreeItemData() as [$title, $description, $location, $user_id, $category_id])
        {
            $category = $manager->getRepository(Category::class)->find($category_id);
            $user_id = $manager->getRepository(User::class)->find($user_id);
            $free_item = new FreeItem();
            $free_item->setTitle($title);
            $free_item->setDescription($description);
            $free_item->setCategory($category);
            $free_item->setLocation($location);
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

            ['Single Bed', 'blah blah blah', 'Bedminster', 2, 1],
            ['Wardrobe', 'blah blah blah', 'Knowle', 2, 1],
            ['Chest of Draws', 'blah blah blah', 'Wells', 2, 1],

            ['Compost', 'blah blah blah', 'Clifton', 2, 2],
            ['Green House', 'blah blah blah', 'Clifton', 2, 2],
            ['Shed', 'blah blah blah', 'Redcliffe', 2, 2],

            ['Lego', 'blah blah blah', 'Clifton', 2, 3],
            ['Board games', 'blah blah blah', 'Clifton', 2, 3],
            ['Action Fugures', 'blah blah blah', 'Southmead', 2, 3],

            ['Boxing Stuff', 'blah blah blah', 'Totterdown', 2, 4],
            ['Bicycle', 'blah blah blah', 'Brislington', 2, 4],
            ['Weights Bench', 'blah blah blah', 'St Annes', 2, 4],

            ['DVD Player', 'blah blah blah', 'Keynsham', 2, 5],
            ['Stereo', 'blah blah blah', 'Redfield', 2, 5],
            ['AV Receiver', 'blah blah blah', 'Hanham', 2, 5],

            ['Blu Rays', 'blah blah blah', 'St george', 3, 6],
            ['Cds', 'blah blah blah', 'Hartcliffe', 3, 6],
            ['Books', 'blah blah blah', 'Longwell Green', 3, 6],

            ['Collectables', 'blah blah blah', 'Gloucester Road', 3, 7],
            ['Porcelain', 'blah blah blah', 'Redfield', 3, 7],
            ['Garage Door', 'blah blah blah', 'Redfield', 3, 7],

            ['Cheese', 'blah blah blah', 'Bedminster', 3, 8],
            ['Chocolate', 'blah blah blah', 'Henleaze', 3, 8],
            ['Tins of Beans', 'blah blah blah', 'Filton', 3, 8],

            ['Roof Rack', 'blah blah blah', 'Portishead', 3, 9],
            ['Corsa Bumper', 'blah blah blah', 'Thornbury', 3, 9],
            ['Windcreen Wipers', 'blah blah blah', 'Almondsbury', 3, 9],

            ['Work Bench', 'blah blah blah', 'Bedminster', 3, 10],
            ['Tool Box', 'blah blah blah', 'Henleaze', 3, 10],
            ['Old Hammers', 'blah blah blah', 'Filton', 3, 10],

            ['Jiffy Bags', 'blah blah blah', 'Westbury-On-Trym', 3, 11],
            ['Bubble Wrap', 'blah blah blah', 'Horfield', 3, 11],
            ['Very Bags', 'blah blah blah', 'Eastville', 3, 11]

        ];
    }

    public function getDependencies()
        {
            return array(
                UserFixtures::class,
            );
        }

}
