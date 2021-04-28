<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Voiture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $marque1 = new Marque();
        $marque1->setLibelle('Hyundai');
        $manager->persist($marque1);

        $marque2 = new Marque();
        $marque2->setLibelle('Renault');
        $manager->persist($marque2);

        $modele1 = new Modele();
        $modele1->setLibelle('IX 35')
            -> setMarque($marque1)
            ->setImage('modele1.jpg')
            ->setPrixMoyen(15000);
        $manager->persist($modele1);

        $modele2 = new Modele();
        $modele2->setLibelle('Santa Fe')
            -> setMarque($marque1)
            ->setImage('modele2.jpg')
            ->setPrixMoyen(15000);
        $manager->persist($modele2);

        $modele3 = new Modele();
        $modele3->setLibelle('Clio')
            -> setMarque($marque2)
            ->setImage('modele3.jpg')
            ->setPrixMoyen(15000);
        $manager->persist($modele3);

        $modele4 = new Modele();
        $modele4->setLibelle('Mégane')
            -> setMarque($marque2)
            ->setImage('modele4.jpg')
            ->setPrixMoyen(15000);
        $manager->persist($modele4);

        $modele5 = new Modele();
        $modele5->setLibelle('Zoé')
            -> setMarque($marque2)
            ->setImage('modele5.jpg')
            ->setPrixMoyen(15000);
        $manager->persist($modele5);

        $faker = \Faker\Factory::create('fr_FR'); 
        
        $arrayModeles = [$modele1, $modele2, $modele3, $modele4, $modele5];

        foreach($arrayModeles as $modele)
        {
            $rand = rand(3,5);
            for($i=0; $i <=$rand; $i++)
            {
                $voiture = new Voiture();
                $voiture->setImmatriculation($faker->regexify('[A-Z]{2}[0-9]{3,4}[A-Z]{2}'))
                ->setPortes($faker->randomElement($array = array(3, 5)))
                ->setAnnee($faker->numberBetween($min = 1990, $max = 2019))
                ->setModele($modele);

                $manager->persist($voiture);
            }
        }

        $manager->flush();
    }
}
