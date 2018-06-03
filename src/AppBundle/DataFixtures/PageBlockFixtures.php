<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Page;
use AppBundle\Entity\PageBlock;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PageBlockFixtures extends FixtureHelper implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_PAGE; $i++) {
            /** @var Page $page */
            $page = $this->getReference('page-' . $i);
            for ($j = 1; $j <= self::NB_PAGE_BLOCK; $j++) {
                $block = (new PageBlock())
                    ->setTitle($this->faker->text(15))
                    ->setContent($this->faker->paragraph)
                    ->setPosition($j)
                    ->setPage($page);

                $manager->persist($block);
                $this->addReference('page-' . $i . 'block-' . $j, $block);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PageFixtures::class
        ];
    }
}
