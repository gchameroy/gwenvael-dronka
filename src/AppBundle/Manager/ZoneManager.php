<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Zone;
use AppBundle\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ZoneManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ZoneRepository */
    private $zoneRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->zoneRepository = $this->entityManager->getRepository(Zone::class);
    }

    public function get(int $id, bool $check = true): Zone
    {
        /** @var $zone Zone */
        $zone = $this->zoneRepository->find($id);
        if ($check) {
            $this->checkZone($zone);
        }

        return $zone;
    }

    public function getList(): array
    {
        return $this->zoneRepository->findAll();
    }

    public function getNew(): Zone
    {
        return new Zone();
    }

    public function save(Zone $zone): Zone
    {
        $this->entityManager->persist($zone);
        $this->entityManager->flush();

        return $zone;
    }

    public function remove(?Zone $zone): void
    {
        if (!$zone) {
            return;
        }

        $this->entityManager->remove($zone);
        $this->entityManager->flush();
    }

    private function checkZone(?Zone $zone): void
    {
        if (!$zone) {
            throw new NotFoundHttpException();
        }
    }
}
