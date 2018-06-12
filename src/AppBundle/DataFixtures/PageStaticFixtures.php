<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\PageStatic;
use Doctrine\Common\Persistence\ObjectManager;

class PageStaticFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        $pages = [
            ['titleSeo' => 'Accueil'],
            ['titleSeo' => 'Tarifs'],
            ['titleSeo' => 'Contact'],
        ];

        for ($i = 1; $i <= self::NB_PAGE_STATIC; ++$i) {
            $pageStatic = (new PageStatic())
                ->setTitleSEO($pages[$i - 1]['titleSeo'])
                ->setDescriptionSEO($this->faker->text(100));

            $manager->persist($pageStatic);
            $this->setReference('page-static-' . $i, $pageStatic);
        }
        $manager->flush();
    }
}
