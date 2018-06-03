<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\PageBlockAction;
use Doctrine\Common\Persistence\ObjectManager;

class PageBlockActionFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        $actions = [
            ['label' => 'Aucune action', 'route' => null],
            ['label' => 'Voir nos tarifs', 'route' => 'website_prices'],
            ['label' => 'Prendre contact', 'route' => 'website_contact'],
        ];

        for ($i = 1; $i <= self::NB_PAGE_BLOCK_ACTION; $i++) {
            $action = (new PageBlockAction())
                ->setLabel($actions[$i - 1]['label'])
                ->setRoute($actions[$i - 1]['route']);

            $manager->persist($action);
            $this->addReference('page-block-action-' . $i, $action);
        }
        $manager->flush();
    }
}
