<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Price;
use Doctrine\Common\Persistence\ObjectManager;

class PriceFixtures extends FixtureHelper
{
    /** @var ObjectManager */
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->loadPrices();
        $this->loadOffers();
    }

    private function loadPrices()
    {
        $prices = [
            ['title' => 'Individuel', 'price' => 250, 'label' => '5 cours', 'description' => 'Dans l\'un de nos parcs'],
            ['title' => 'Collectif', 'price' => 200, 'label' => '5 cours', 'description' => 'Dans l\'un de nos parcs'],
            ['title' => 'À domicile', 'price' => 350, 'label' => '5 cours', 'description' => 'Chez vous']
        ];

        for ($i = 1; $i <= self::NB_PRICE; $i++) {
            $price = (new Price())
                ->setTitle($prices[$i - 1]['title'])
                ->setPrice($prices[$i - 1]['price'])
                ->setLabel($prices[$i - 1]['label'])
                ->setDescription($prices[$i - 1]['description']);

            $this->manager->persist($price);
            $this->addReference('price-' . $i, $price);
        }
        $this->manager->flush();
    }

    private function loadOffers()
    {
        $offers = [
            ['title' => 'Individuel + Collectif', 'price' => 400, 'label' => '10 cours', 'description' => "5 cours individuels\n5 cours collectifs"],
            ['title' => 'À domicile + Collectif', 'price' => 500, 'label' => '10 cours', 'description' => "5 cours à domicile\n5 cours collectifs"]
        ];

        for ($i = 1; $i <= self::NB_PRICE_OFFER; $i++) {
            $price = (new Price())
                ->setTitle($offers[$i - 1]['title'])
                ->setPrice($offers[$i - 1]['price'])
                ->setLabel($offers[$i - 1]['label'])
                ->setDescription($offers[$i - 1]['description'])
                ->setOffer(true);

            $this->manager->persist($price);
            $this->addReference('price-offer-' . $i, $price);
        }
        $this->manager->flush();
    }
}
