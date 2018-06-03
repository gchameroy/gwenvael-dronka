<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Setting;
use AppBundle\Entity\SettingSocialNetwork;
use AppBundle\Entity\SocialNetwork;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SettingSocialNetworkFixtures extends FixtureHelper implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $socialNetworks = [
            ['url' => 'https://www.facebook.com/', 'social-network' => '1'],
            ['url' => 'https://plus.google.com/', 'social-network' => '2'],
            ['url' => 'https://twitter.com/', 'social-network' => '6'],
        ];

        /** @var Setting $setting */
        $setting = $this->getReference('setting');
        for ($i = 1; $i <= self::NB_SETTING_SOCIAL_NETWORK; $i++) {
            /** @var SocialNetwork $socialNetwork */
            $socialNetwork = $this->getReference('social-network-' . $socialNetworks[$i - 1]['social-network']);
            $settingSocialNetwork = (new SettingSocialNetwork())
                ->setUrl($socialNetworks[$i - 1]['url'])
                ->setSetting($setting)
                ->setSocialNetwork($socialNetwork);

            $manager->persist($settingSocialNetwork);
            $this->addReference('setting-social-network-' . $i, $settingSocialNetwork);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SettingFixtures::class,
            SocialNetworkFixtures::class,
        ];
    }
}
