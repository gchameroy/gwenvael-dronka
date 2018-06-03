<?php

namespace AppBundle\Manager;

use AppBundle\Entity\PageBlock;
use AppBundle\Entity\PageBlockImage;
use AppBundle\Repository\PageBlockImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageBlockImageManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PageBlockImageRepository */
    private $imageRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->imageRepository = $this->entityManager->getRepository(PageBlockImage::class);
    }

    public function getList(PageBlock $block): array
    {
        return $this->imageRepository->findBy(
            ['block' => $block],
            ['id' => 'asc']
        );
    }

    public function get(int $id, bool $check = true): PageBlockImage
    {
        /** @var $image PageBlockImage */
        $image = $this->imageRepository->find($id);
        if ($check) {
            $this->checkImage($image);
        }

        return $image;
    }

    public function getNew(PageBlock $block): PageBlockImage
    {
        return (new PageBlockImage())
            ->setBlock($block);
    }

    public function save(PageBlockImage $image): PageBlockImage
    {
        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $image;
    }

    public function remove(PageBlockImage $image): PageBlockImage
    {
        $this->entityManager->remove($image);
        $this->entityManager->flush();

        return $image;
    }

    private function checkImage(?PageBlockImage $image): void
    {
        if (!$image) {
            throw new NotFoundHttpException();
        }
    }
}
