<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\SocialNetwork;
use Doctrine\Common\Persistence\ObjectManager;

class SocialNetworkFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        $socialNetworks = [
            ['label' => 'Facebook', 'icon' => 'fa fa-facebook-f'],
            ['label' => 'Google Plus', 'icon' => 'fa fa-google-plus'],
            ['label' => 'Instagram', 'icon' => 'fa fa-instagram'],
            ['label' => 'Linkedin', 'icon' => 'fa fa-linkedin'],
            ['label' => 'Pinterest', 'icon' => 'fa fa-pinterest-p'],
            ['label' => 'Twitter', 'icon' => 'fa fa-twitter'],
            ['label' => 'Vimeo', 'icon' => 'fa fa-vimeo'],
            ['label' => 'Youtube', 'icon' => 'fa fa-youtube'],
        ];

        for ($i = 1; $i <= self::NB_SOCIAL_NETWORK; $i++) {
            $socialNetwork = (new SocialNetwork())
                ->setLabel($socialNetworks[$i - 1]['label'])
                ->setIcon($socialNetworks[$i - 1]['icon']);

            $manager->persist($socialNetwork);
            $this->addReference('social-network-' . $i, $socialNetwork);
        }

        $manager->flush();
    }
}
