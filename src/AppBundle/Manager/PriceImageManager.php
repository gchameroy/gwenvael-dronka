<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Price;
use AppBundle\Entity\PriceImage;
use AppBundle\Repository\PriceImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PriceImageManager
{
    const IMAGE_WIDTH = 650;
    const IMAGE_HEIGHT = 433;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PriceImageRepository */
    private $imageRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->imageRepository = $this->entityManager->getRepository(PriceImage::class);
    }

    public function getList(Price $price): array
    {
        return $this->imageRepository->findBy(
            ['price' => $price],
            ['id' => 'asc']
        );
    }

    public function get(int $id, bool $check = true): PriceImage
    {
        /** @var $image PriceImage */
        $image = $this->imageRepository->find($id);
        if ($check) {
            $this->checkImage($image);
        }

        return $image;
    }

    public function getNew(Price $price): PriceImage
    {
        return (new PriceImage())
            ->setPrice($price);
    }

    public function save(PriceImage $image): PriceImage
    {
        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $image;
    }

    public function remove(?PriceImage $image): void
    {
        if (!$image) {
            return;
        }

        $this->entityManager->remove($image);
        $this->entityManager->flush();

    }

    private function checkImage(?PriceImage $image): void
    {
        if (!$image) {
            throw new NotFoundHttpException();
        }
    }
}
