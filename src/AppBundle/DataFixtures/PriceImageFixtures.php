<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Price;
use AppBundle\Entity\PriceImage;
use AppBundle\Manager\PriceImageManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

class PriceImageFixtures extends FixtureHelper implements DependentFixtureInterface
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
        for ($i = 1; $i <= self::NB_PRICE; $i++) {
            /** @var Price $price */
            $price = $this->getReference('price-' . $i);
            for ($j = 1; $j <= self::NB_PRICE_IMAGE; $j++) {
                $image = (new PriceImage())
                    ->setPath($this->faker->image($directory, PriceImageManager::IMAGE_WIDTH, PriceImageManager::IMAGE_HEIGHT, 'cats', false))
                    ->setPrice($price);

                $manager->persist($image);
                $this->addReference('price-' . $i . 'image-' . $j, $image);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PriceFixtures::class
        ];
    }
}
