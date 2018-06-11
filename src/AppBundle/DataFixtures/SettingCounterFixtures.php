<?php

namespace AppBundle\DataFixtures;

use AppBundle\DataFixtures\Helper\FixtureHelper;
use AppBundle\Entity\Counter;
use AppBundle\Entity\Setting;
use AppBundle\Entity\SettingCounter;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SettingCounterFixtures extends FixtureHelper implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var Setting $setting */
        $setting = $this->getReference('setting');
        for ($i = 1; $i <= self::NB_COUNTER; $i++) {
            /** @var Counter $counter */
            $counter = $this->getReference('counter-' . $i);
            $settingCounter = (new SettingCounter())
                ->setValue($this->faker->randomNumber(3))
                ->setSetting($setting)
                ->setCounter($counter);

            $manager->persist($settingCounter);
            $this->addReference('setting-counter-' . $i, $settingCounter);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SettingFixtures::class,
            CounterFixtures::class,
        ];
    }
}
