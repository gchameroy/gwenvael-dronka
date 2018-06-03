<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Page;
use AppBundle\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PageRepository */
    private $pageRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->pageRepository = $this->entityManager->getRepository(Page::class);
    }

    public function get(int $id, bool $check = true): Page
    {
        /** @var $page Page */
        $page = $this->pageRepository->find($id);
        if ($check) {
            $this->checkPage($page);
        }

        return $page;
    }

    public function getBySlug(string $slug): Page
    {
        /** @var $page Page */
        $page = $this->pageRepository->findOneBy([
            'slug' => $slug
        ]);
        $this->checkPage($page);

        return $page;
    }

    public function getLesson(): Page
    {
        /** @var $page Page */
        $page = $this->pageRepository->find(1);
        $this->checkPage($page);

        return $page;
    }

    public function getList(): array
    {
        return $this->pageRepository->findAll();
    }

    public function getNew(): Page
    {
        return new Page();
    }

    public function save(Page $page): Page
    {
        $this->entityManager->persist($page);
        $this->entityManager->flush();

        return $page;
    }

    public function remove(?Page $page): void
    {
        if (!$page) {
            return;
        }

        $this->entityManager->remove($page);
        $this->entityManager->flush();
    }

    private function checkPage(?Page $page): void
    {
        if (!$page) {
            throw new NotFoundHttpException();
        }
    }
}
