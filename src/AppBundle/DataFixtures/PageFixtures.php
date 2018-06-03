<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Page;
use Doctrine\Common\Persistence\ObjectManager;

class PageFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        $pages = [
            ['title' => 'Cours', 'titreSeo' => '', 'descriptionSeo' => '', 'deletable' => false],
            ['title' => 'Sites', 'titreSeo' => '', 'descriptionSeo' => '', 'deletable' => true],
        ];

        for ($i = 1; $i <= self::NB_PAGE; $i++) {
            $page = (new Page())
                ->setTitle($pages[$i - 1]['title'])
                ->setTitleSeo($pages[$i - 1]['titreSeo'])
                ->setDescriptionSeo($pages[$i - 1]['descriptionSeo'])
                ->setDeletable($pages[$i - 1]['deletable']);

            $manager->persist($page);
            $this->addReference('page-' . $i, $page);
        }
        $manager->flush();
    }
}
