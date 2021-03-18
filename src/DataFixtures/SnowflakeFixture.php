<?php

namespace App\DataFixtures;

use App\Entity\Snowflake;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SnowflakeFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 3; $i++) {
            $snowflake = new Snowflake();
            $snowflake->setName("flocon{$i}")
                ->setLuckyNumber($i)
                ->setDescription("'Je suis le flocon {$i}")
                ->setCreatedAt(new \DateTime('now'));

            $manager->persist($snowflake);
        }
        $manager->flush();
    }
}
