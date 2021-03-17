<?php

namespace App\DataFixtures;

use App\Entity\Snowflake;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SnowflakeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $snowflake1 = new Snowflake();
        $snowflake1->setName('flocon1')
            ->setLuckyNumber(1)
            ->setDescription('Je suis le flocon 1')
            ->setCreatedAt(new \DateTime('now'));

        $manager->persist($snowflake1);

        $snowflake2 = new Snowflake();
        $snowflake2->setName('flocon2')
            ->setLuckyNumber(2)
            ->setDescription('Je suis le flocon 2')
            ->setCreatedAt(new \DateTime('now'));

        $manager->persist($snowflake2);


        $snowflake3 = new Snowflake();
        $snowflake3->setName('flocon3')
            ->setLuckyNumber(3)
            ->setDescription('Je suis le flocon 3')
            ->setCreatedAt(new \DateTime());

        $manager->persist($snowflake3);


        $manager->flush();
    }
}
