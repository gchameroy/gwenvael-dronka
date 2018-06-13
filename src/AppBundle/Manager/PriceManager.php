<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Price;
use AppBundle\Repository\PriceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PriceManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PriceRepository */
    private $priceRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->priceRepository = $this->entityManager->getRepository(Price::class);
    }

    public function get(int $id, bool $check = true): Price
    {
        /** @var $price Price */
        $price = $this->priceRepository->find($id);
        if ($check) {
            $this->checkPrice($price);
        }

        return $price;
    }

    /**
     * @return array|Price[]
     */
    public function getList(): array
    {
        return $this->priceRepository->findAll();
    }

    public function getNew(): Price
    {
        return new Price();
    }

    public function save(Price $price): Price
    {
        $this->entityManager->persist($price);
        $this->entityManager->flush();

        return $price;
    }

    public function remove(?Price $price): void
    {
        if (!$price) {
            return;
        }

        $this->entityManager->remove($price);
        $this->entityManager->flush();
    }

    private function checkPrice(?Price $price): void
    {
        if (!$price) {
            throw new NotFoundHttpException();
        }
    }
}
