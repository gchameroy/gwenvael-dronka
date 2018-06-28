<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Page;
use AppBundle\Manager\PageManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

class PageFixtures extends FixtureHelper
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
        $pages = [
            ['title' => 'Troubles', 'titreSeo' => '', 'descriptionSeo' => '', 'deletable' => true],
            ['title' => 'Sites', 'titreSeo' => '', 'descriptionSeo' => '', 'deletable' => true],
        ];

        $directory = $this->kernel->getRootDir() . '/../web/images';
        for ($i = 1; $i <= self::NB_PAGE; $i++) {
            $page = (new Page())
                ->setTitle($pages[$i - 1]['title'])
                ->setTitleSeo($pages[$i - 1]['titreSeo'])
                ->setDescriptionSeo($pages[$i - 1]['descriptionSeo'])
                ->setDeletable($pages[$i - 1]['deletable'])
                ->setImage($this->faker->image($directory, PageManager::IMAGE_WIDTH, PageManager::IMAGE_HEIGHT, 'cats', false));

            $manager->persist($page);
            $this->addReference('page-' . $i, $page);
        }
        $manager->flush();
    }
}
