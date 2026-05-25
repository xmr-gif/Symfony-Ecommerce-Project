<?php

/**
 * Etape 1 <?php 2 modifications remade by Oussama
 */

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            [
                'name' => 'Whole Bean',
                'description' => 'Unprocessed heritage harvests.',
                'slug' => 'whole-bean',
                'displayOrder' => 1,
            ],
            [
                'name' => 'Brewing Kits',
                'description' => 'The essential laboratory tools.',
                'slug' => 'brewing-kits',
                'displayOrder' => 2,
            ],
            [
                'name' => 'Accessories',
                'description' => 'Tactile details for the station.',
                'slug' => 'accessories',
                'displayOrder' => 3,
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = new Category();
            $category->setName($categoryData['name']);
            $category->setDescription($categoryData['description']);
            $category->setSlug($categoryData['slug']);
            $category->setDisplayOrder($categoryData['displayOrder']);

            $manager->persist($category);
            $this->addReference('category_' . $category->getSlug(), $category);
        }

        $manager->flush();
    }
}
