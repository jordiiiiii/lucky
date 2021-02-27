<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Premi;
use App\Entity\Organisme;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {


        for ($i = 0; $i < 10; $i++) {
            $organisme = new Organisme();
            $organisme->setNomorg('nomOrganimse '.$i);
            $organisme->setNIF('nifOrganimse '.$i);
            $manager->persist($organisme);
        }


        // create 20 products! Bam!
        for ($i = 0; $i < 5; $i++) {
            $premi = new Premi();
            $premi->setNom('nom '.$i);
            $premi->setValor(mt_rand(10, 100));
            $premi->setData(new \DateTime());
            $premi->setOrganisme($organisme);
            $manager->persist($premi);
        }

        $manager->flush();
    }
}

//When using the ORM in console
//php bin/console doctrine:fixtures:load
