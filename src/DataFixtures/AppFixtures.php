<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Sneaker;
use App\Entity\Showroom;

class AppFixtures extends Fixture
{
    
    private static function SneakersDataGenerator()
    {
        yield ["Air Force 1", "Blanc", ["La caverne d'Ali Baba", "Evry"] ];
        yield ["Air Force 1", "Noir", ["La caverne d'Ali Baba", "Evry"] ];
        yield ["Stan Smith", "Blanc", ["L'antre de Saad", "Ajaccio"] ];
        yield ["Dunk Low", "University Blue", ["La caverne d'Ali Baba", "Evry"] ];
        yield ["Dunk Low", "Green Lemon", ["L'antre de Saad", "Ajaccio"] ];
    } 
    
    private static function ShowroomDataGenerator()
    {
        yield ["La caverne d'Ali Baba", "Evry"];
        yield ["L'antre de Saad", "Ajaccio"];
    } 
    
    
    
    public function load(ObjectManager $manager): void
    {    
        // Une fois l'instance de Sneaker sauvée en base de données,
        // elle dispose d'un identifiant généré par Doctrine, et peut
        // donc être sauvegardée comme future référence.
       
        
        foreach (self::ShowroomDataGenerator() as [$name, $location] )
        {
            $showroom = new Showroom();
            $showroom->setName($name);
            $showroom->setLocation($location);
            $manager->persist($showroom);
        }
        $manager->flush();
        
       #$this->getRelation(self::SNEAKER_SHOWROOM_RELATION, $showroom);
        
       $showroomRepo = $manager->getRepository(Showroom::class);
       
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::SneakersDataGenerator() as [ $model, $color, [$name,$location] ] )
        {
            $showroom = $showroomRepo->findOneBy(['name' => $name, 'location' => $location]);
            $sneaker = new Sneaker();
            $sneaker->setModel($model);
            $sneaker->setColor($color);
            $sneaker->setRelation($showroom) ;
            $manager->persist($sneaker);
        }
        $manager->flush();
        
    }
}