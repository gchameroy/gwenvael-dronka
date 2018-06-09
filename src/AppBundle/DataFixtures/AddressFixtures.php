<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Address;
use Doctrine\Common\Persistence\ObjectManager;

class AddressFixtures extends FixtureHelper
{
    /** @var ObjectManager */
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->loadForZone();
    }

    private function loadForZone()
    {
        $addresses = [
            ['title' => 'Site Alpha', 'city' => 'Achères', 'zipCode' => '78260', 'country' => 'France', 'latitude' => '48.9241025', 'longitude' => '1.9900117'],
            ['title' => 'Site Beta', 'city' => 'Champagne sur Seine', 'zipCode' => '77430', 'country' => 'France', 'latitude' => '48.9268466', 'longitude' => '2.330664'],
            ['title' => 'Site Delta', 'city' => 'Foulain', 'zipCode' => '52800', 'country' => 'France', 'latitude' => '48.8039192', 'longitude' => '2.0841591'],
        ];

        for ($i = 1; $i <= self::NB_ZONE; $i++) {
            $address = (new Address())
                ->setTitle($addresses[$i - 1]['title'])
                ->setCity($addresses[$i - 1]['city'])
                ->setZipCode($addresses[$i - 1]['zipCode'])
                ->setCountry($addresses[$i - 1]['country'])
                ->setLatitude($addresses[$i - 1]['latitude'])
                ->setLongitude($addresses[$i - 1]['longitude']);

            $this->manager->persist($address);
            $this->addReference('address-zone-' . $i, $address);
        }

        $this->manager->flush();
    }
}
