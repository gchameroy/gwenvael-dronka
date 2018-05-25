<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Page;
use Doctrine\Common\Persistence\ObjectManager;

class PageFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_PAGE; $i++) {
            $page = (new Page())
                ->setTitle('Page N°' . $i)
                ->setDescription('Description N°' . $i)
                ->setTitleSeo('Titre Seo ' . $i)
                ->setDescriptionSeo('Description Seo ' . $i)
                ->setPublishedAt(new \DateTime('2018-05-05'));

            $manager->persist($page);
            $this->addReference('page-' . $i, $page);
        }
        $manager->flush();
    }
}
