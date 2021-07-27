<?php

declare(strict_types=1);

namespace App\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoadFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loader = new PlNativeLoader();

        $files = [];

        foreach (glob(__DIR__ . '/dev/*.yaml') as $file) {
            $files[] = $file;
        }

        $objectSet = $loader->loadFiles($files)->getObjects();

        foreach ($objectSet as $object) {
            $manager->persist($object);
        }

        $manager->flush();
    }
}