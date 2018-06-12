<?php

namespace AppBundle\Manager;

use AppBundle\Entity\PageStatic;
use AppBundle\Repository\PageStaticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageStaticManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var PageStaticRepository */
    private $pageStaticRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->pageStaticRepository = $entityManager->getRepository(PageStatic::class);
    }

    public function get(int $id): PageStatic
    {
        /** @var $pageStatic PageStatic */
        $pageStatic = $this->pageStaticRepository->find($id);
        $this->checkPageStatic($pageStatic);

        return $pageStatic;
    }

    public function getList(): array
    {
        return $this->pageStaticRepository->findAll();
    }

    public function save(PageStatic $pageStatic): PageStatic
    {
        $this->entityManager->persist($pageStatic);
        $this->entityManager->flush();

        return $pageStatic;
    }

    private function checkPageStatic(?PageStatic $pageStatic): void
    {
        if (!$pageStatic) {
            throw new NotFoundHttpException();
        }
    }
}
