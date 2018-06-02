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
            ['title' => 'Cours', 'description' => $this->faker->paragraph, 'titreSeo' => '', 'descriptionSeo' => ''],
            ['title' => 'Sites', 'description' => $this->faker->paragraph, 'titreSeo' => '', 'descriptionSeo' => ''],
        ];

        for ($i = 1; $i <= self::NB_PAGE; $i++) {
            $page = (new Page())
                ->setTitle($pages[$i - 1]['title'])
                ->setDescription($pages[$i - 1]['description'])
                ->setTitleSeo($pages[$i - 1]['titreSeo'])
                ->setDescriptionSeo($pages[$i - 1]['descriptionSeo']);

            $manager->persist($page);
            $this->addReference('page-' . $i, $page);
        }
        $manager->flush();
    }
}
