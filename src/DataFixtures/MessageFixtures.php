<?php

namespace App\DataFixtures;

use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MessageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i = 1; $i <= 10; $i++){
            $message = new Message();
            $message->setNom($faker->lastName)
                    ->setPrenom($faker->firstName)
                    ->setEmail($faker->freeEmail)
                    ->setMessage($faker->text)
                    ->setIsTreated(false)
                    ->setCreatedAt($faker->dateTimeBetween('-3 months'));

            $manager->persist($message);
        }

        $manager->flush();
    }
}
