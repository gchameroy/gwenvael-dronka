<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\PageBlock;
use AppBundle\Entity\PageBlockImage;
use AppBundle\Manager\PageBlockImageManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

class PageBlockImageFixtures extends FixtureHelper implements DependentFixtureInterface
{
    /** @var KernelInterface */
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        parent::__construct();
    }

    public function load(ObjectManager $manager)
    {
        $directory = $this->kernel->getRootDir() . '/../web/images';
        for ($i = 1; $i <= self::NB_PAGE; $i++) {
            for ($j = 1; $j <= self::NB_PAGE_BLOCK; $j++) {
                /** @var PageBlock $block */
                $block = $this->getReference('page-' . $i . 'block-' . $j);
                for ($k = 1; $k <= self::NB_PAGE_BLOCK_IMAGE; $k++) {
                    $image = (new PageBlockImage())
                        ->setPath($this->faker->image($directory, PageBlockImageManager::IMAGE_WIDTH, PageBlockImageManager::IMAGE_HEIGHT, 'cats', false))
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
