<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Price;
use Doctrine\Common\Persistence\ObjectManager;

class PriceFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        $prices = [
            ['title' => 'Individuel', 'price' => 250, 'label' => '5 cours', 'description' => 'Dans l\'un de nos parcs', 'offer' => false],
            ['title' => 'Collectif', 'price' => 200, 'label' => '5 cours', 'description' => 'Dans l\'un de nos parcs', 'offer' => false],
            ['title' => 'À domicile', 'price' => 350, 'label' => '5 cours', 'description' => 'Chez vous', 'offer' => false],
            ['title' => 'Individuel + Collectif', 'price' => 400, 'label' => '10 cours', 'description' => "5 cours individuels\n5 cours collectifs", 'offer' => true],
            ['title' => 'À domicile + Collectif', 'price' => 500, 'label' => '10 cours', 'description' => "5 cours à domicile\n5 cours collectifs", 'offer' => true],
        ];

        for ($i = 1; $i <= self::NB_PRICE; $i++) {
            $price = (new Price())
                ->setTitle($prices[$i - 1]['title'])
                ->setPrice($prices[$i - 1]['price'])
                ->setLabel($prices[$i - 1]['label'])
                ->setDescription($prices[$i - 1]['description'])
                ->setContent(sprintf('<p>%s</p>', $this->faker->paragraph))
                ->setOffer($prices[$i - 1]['offer']);

            $manager->persist($price);
            $this->addReference('price-' . $i, $price);
        }
        $manager->flush();
    }
}
