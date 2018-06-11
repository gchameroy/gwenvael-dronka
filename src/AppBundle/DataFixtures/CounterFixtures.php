<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Counter;
use Doctrine\Common\Persistence\ObjectManager;

class CounterFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        $counters = [
            ['label' => 'Maîtres'],
            ['label' => 'Chiens'],
            ['label' => 'Cours'],
            ['label' => 'Friandises'],
        ];

        for ($i = 1; $i <= self::NB_COUNTER; $i++) {
            $counter = (new Counter())
                ->setLabel($counters[$i - 1]['label']);

            $manager->persist($counter);
            $this->addReference('counter-' . $i, $counter);
        }

        $manager->flush();
    }
}
