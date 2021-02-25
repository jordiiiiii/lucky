<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Premi;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $premi = new Premi();
            $premi->setNom('nom '.$i);
            $premi->setValor(mt_rand(10, 100));
            $premi->setData(new \DateTime());
            $manager->persist($premi);
        }

        $manager->flush();
    }
}

//When using the ORM in console
//php bin/console doctrine:fixtures:load
