<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Setting;
use AppBundle\Repository\SettingRepository;
use Doctrine\ORM\EntityManagerInterface;

class SettingManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var SettingRepository */
    private $settingRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->settingRepository = $this->entityManager->getRepository(Setting::class);
    }

    public function getCurrent(): Setting
    {
        /** @var Setting $setting */
        $setting = $this->settingRepository->getCurrent();

        return $setting ? $setting : $this->createNew();
    }

    private function createNew(): Setting
    {
        $setting = new Setting();

        $this->entityManager->persist($setting);
        $this->entityManager->flush();

        return $setting;
    }
}
