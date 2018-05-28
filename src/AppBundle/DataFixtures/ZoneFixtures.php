<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Address;
use AppBundle\Entity\Zone;
use Doctrine\Common\Persistence\ObjectManager;

class ZoneFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_ZONE; $i++) {
            /** @var Address $address */
            $address = $this->getReference('address-zone-' . $i);
            $zone = (new Zone())
                ->setAddress($address);

            $manager->persist($zone);
            $this->addReference('zone-' . $i, $zone);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AddressFixtures::class,
        ];
    }
}
