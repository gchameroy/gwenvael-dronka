<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Setting;
use Doctrine\Common\Persistence\ObjectManager;

class SettingFixtures extends FixtureHelper
{
    public function load(ObjectManager $manager)
    {
        $setting = new Setting();

        $manager->persist($setting);
        $this->addReference('setting', $setting);

        $manager->flush();
    }
}
