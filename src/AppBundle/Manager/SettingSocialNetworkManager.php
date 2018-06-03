<?php

namespace AppBundle\Manager;

use AppBundle\Entity\SettingSocialNetwork;
use AppBundle\Repository\SettingSocialNetworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SettingSocialNetworkManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var SettingSocialNetworkRepository */
    private $repository;

    /** @var SettingManager */
    private $settingManager;


    public function __construct(EntityManagerInterface $entityManager, SettingManager $settingManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(SettingSocialNetwork::class);
        $this->settingManager = $settingManager;
    }

    public function getList(): array
    {
        return $this->repository->findBy([
            'setting' => $this->settingManager->getCurrent()
        ]);
    }

    public function get(int $id, bool $check = true): SettingSocialNetwork
    {
        /** @var $entity SettingSocialNetwork */
        $entity = $this->repository->find($id);
        if ($check) {
            $this->check($entity);
        }

        return $entity;
    }

    public function getNew(): SettingSocialNetwork
    {
        return (new SettingSocialNetwork())
            ->setSetting($this->settingManager->getCurrent());
    }

    public function save(SettingSocialNetwork $entity): SettingSocialNetwork
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }

    public function remove(?SettingSocialNetwork $entity): void
    {
        if (!$entity) {
            return;
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    private function check(?SettingSocialNetwork $entity): void
    {
        if (!$entity) {
            throw new NotFoundHttpException();
        }
    }
}
