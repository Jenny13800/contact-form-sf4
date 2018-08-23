<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class MessageFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

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

        $admin = new Admin();

        // demande à encoder un password
        $password = $this->encoder->encodePassword($admin, "admin");

        $admin->setUsername("admin")
            ->setPassword($password);

        $manager->persist($admin);

        $manager->flush();
    }
}
