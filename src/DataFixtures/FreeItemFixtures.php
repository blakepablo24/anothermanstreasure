<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\FreeItem;
use App\Entity\Category;

class FreeItemFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach($this->FreeItemData() as [$title, $description, $location, $category_id])
        {
            $category = $manager->getRepository(Category::class)->find($category_id);
            $free_item = new FreeItem();
            $free_item->setTitle($title);
            $free_item->setDescription($description);
            $free_item->setCategory($category);
            $free_item->setLocation($location);
            $free_item->setDate(new \DateTime());
            $free_item->setTime(new \DateTime());
            $manager->persist($free_item);
        }

        $manager->flush();
    }

    private function FreeItemData()
    {
        return [

            ['Single Bed', 'blah blah blah', 'Bedminster', 1],
            ['Wardrobe', 'blah blah blah', 'Knowle', 1],
            ['Chest of Draws', 'blah blah blah', 'Wells', 1],

            ['Compost', 'blah blah blah', 'Clifton', 2],
            ['Green House', 'blah blah blah', 'Clifton', 2],
            ['Shed', 'blah blah blah', 'Redcliffe', 2],

            ['Lego', 'blah blah blah', 'Clifton', 3],
            ['Board games', 'blah blah blah', 'Clifton', 3],
            ['Action Fugures', 'blah blah blah', 'Southmead', 3],

            ['Boxing Stuff', 'blah blah blah', 'Totterdown', 4],
            ['Bicycle', 'blah blah blah', 'Brislington', 4],
            ['Weights Bench', 'blah blah blah', 'St Annes', 4],

            ['DVD Player', 'blah blah blah', 'Keynsham', 5],
            ['Stereo', 'blah blah blah', 'Redfield', 5],
            ['AV Receiver', 'blah blah blah', 'Hanham', 5],

            ['Blu Rays', 'blah blah blah', 'St george', 6],
            ['Cds', 'blah blah blah', 'Hartcliffe', 6],
            ['Books', 'blah blah blah', 'Longwell Green', 6],

            ['Collectables', 'blah blah blah', 'Gloucester Road', 7],
            ['Porcelain', 'blah blah blah', 'Redfield', 7],
            ['Garage Door', 'blah blah blah', 'Redfield', 7],

            ['Cheese', 'blah blah blah', 'Bedminster', 8],
            ['Chocolate', 'blah blah blah', 'Henleaze', 8],
            ['Tins of Beans', 'blah blah blah', 'Filton', 8],

            ['Roof Rack', 'blah blah blah', 'Portishead', 9],
            ['Corsa Bumper', 'blah blah blah', 'Thornbury', 9],
            ['Windcreen Wipers', 'blah blah blah', 'Almondsbury', 9],

            ['Work Bench', 'blah blah blah', 'Bedminster', 10],
            ['Tool Box', 'blah blah blah', 'Henleaze', 10],
            ['Old Hammers', 'blah blah blah', 'Filton', 10],

            ['Jiffy Bags', 'blah blah blah', 'Westbury-On-Trym', 11],
            ['Bubble Wrap', 'blah blah blah', 'Horfield', 11],
            ['Very Bags', 'blah blah blah', 'Eastville', 11]

        ];
    }
}
