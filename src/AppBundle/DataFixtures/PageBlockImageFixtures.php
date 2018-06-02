<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\PageBlock;
use AppBundle\Entity\PageBlockImage;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PageBlockImageFixtures extends FixtureHelper implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $directory = PageBlockImage::getDirectory();
        for ($i = 1; $i <= self::NB_PAGE; $i++) {
            for ($j = 1; $j <= self::NB_PAGE_BLOCK; $j++) {
                /** @var PageBlock $block */
                $block = $this->getReference('page-' . $i . 'block-' . $j);
                for ($k = 1; $k <= self::NB_PAGE_BLOCK_IMAGE; $k++) {
                    $image = (new PageBlockImage())
                        ->setPath($this->faker->image($directory, 650, 433, 'cats', false))
                        ->setBlock($block);

                    $manager->persist($image);
                    $this->addReference('page-' . $i . 'block-' . $j . 'image-' . $k, $image);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PageBlockFixtures::class
        ];
    }
}
