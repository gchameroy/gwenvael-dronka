<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\PageDisposition;
use Doctrine\Common\Persistence\ObjectManager;

class PageDispositionFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        $dispositions = [
            ['label' => 'Texte + image', 'icon' => 'fa-home'],
            ['label' => '3 collones de texte', 'icon' => 'fa-home'],
        ];

        for ($i = 1; $i <= self::NB_PAGE_DISPOSITION; $i++) {
            $disposition = (new PageDisposition())
                ->setLabel($dispositions[$i - 1]['label'])
                ->setIcon($dispositions[$i - 1]['label']);

            $manager->persist($disposition);
            $this->addReference('page-disposition-' . $i, $disposition);
        }
        $manager->flush();
    }
}
