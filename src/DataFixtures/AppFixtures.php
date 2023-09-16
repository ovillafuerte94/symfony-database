<?php

namespace App\DataFixtures;

use App\Factory\CommentFactory;
use App\Factory\ProductFactory;
use App\Factory\TagFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /* Tags */
        TagFactory::createMany(5);

        /* Products */
        ProductFactory::createMany(20, [
            'comments' => CommentFactory::new()->many(0, 5),
            'tags' => TagFactory::randomRange(2, 5)
        ]);
    }
}
