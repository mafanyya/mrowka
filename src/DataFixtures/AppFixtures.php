<?php

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++){
        $item = new Item();
        $item->setName('item'.$i);
        $item->setPrice(mt_rand(50, 500));
        $manager->persist($item);
        }

        $manager->flush();
    }
}
