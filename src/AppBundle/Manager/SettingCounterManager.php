<?php

namespace AppBundle\Manager;

use AppBundle\Entity\SettingCounter;
use AppBundle\Repository\SettingCounterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SettingCounterManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var SettingCounterRepository */
    private $repository;

    /** @var SettingManager */
    private $settingManager;


    public function __construct(EntityManagerInterface $entityManager, SettingManager $settingManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(SettingCounter::class);
        $this->settingManager = $settingManager;
    }

    public function getList(): array
    {
        return $this->repository->findBy([
            'setting' => $this->settingManager->getCurrent()
        ]);
    }

    public function get(int $id): SettingCounter
    {
        /** @var $settingCounter SettingCounter */
        $settingCounter = $this->repository->find($id);
        $this->check($settingCounter);

        return $settingCounter;
    }

    public function save(SettingCounter $settingCounter): SettingCounter
    {
        $this->entityManager->persist($settingCounter);
        $this->entityManager->flush();

        return $settingCounter;
    }

    private function check(?SettingCounter $settingCounter): void
    {
        if (!$settingCounter) {
            throw new NotFoundHttpException();
        }
    }
}
