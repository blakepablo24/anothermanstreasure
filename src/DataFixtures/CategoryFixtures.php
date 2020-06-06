<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $this->loadCategoriesData($manager);

    }

    private function loadCategoriesData($manager)

    {

        foreach ($this->getCategoriesData() as [$name]) {
            
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);   

        }

        $manager->flush();

    }

    private function getCategoriesData()

    {

        return[

            ['Home', 1],
            ['Garden', 2],
            ['Toys', 3],
            ['Sports', 4],
            ['Electronics', 5],
            ['Media', 6],
            ['Other', 7],
            ['Food Items', 8],
            ['Vehicle Parts / Acessories', 9],
            ['Tools', 10],
            ['Packaging', 11]

        ];

    }

}
