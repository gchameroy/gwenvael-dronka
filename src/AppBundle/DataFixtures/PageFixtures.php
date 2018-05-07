<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PageFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $page = (new Page())
                ->setTitle('Page N°' . $i)
                ->setDescription('Description N°' . $i)
                ->setTitleSeo('Titre Seo ' . $i)
                ->setDescriptionSeo('Description Seo ' . $i)
                ->setPublishedAt(new \DateTime('2018-05-05'));

            $manager->persist($page);
        }
        $manager->flush();
    }
}
