<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Menu;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MenuFixtures extends FixtureHelper implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $menus = [
            ['title' => 'Accueil', 'routeName' => 'website_home', 'routeSlug' => null],
            ['title' => 'Troubles', 'routeName' => 'website_page', 'routeSlug' => 'troubles'],
            ['title' => 'Sites', 'routeName' => 'website_page', 'routeSlug' => 'sites'],
            ['title' => 'Tarifs', 'routeName' => 'website_prices', 'routeSlug' => null],
            ['title' => 'Contact', 'routeName' => 'website_contact', 'routeSlug' => null],
        ];

        for ($i = 1; $i <= self::NB_MENU; $i++) {
            $menu = (new Menu())
                ->setTitle($menus[$i - 1]['title'])
                ->setRouteName($menus[$i - 1]['routeName'])
                ->setRouteSlug($menus[$i - 1]['routeSlug'])
                ->setPosition($i);

            $manager->persist($menu);
            $this->addReference('menu-' . $i, $menu);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PageFixtures::class,
        ];
    }
}
