<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Page;
use AppBundle\Entity\PageBlock;
use AppBundle\Repository\PageBlockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageBlockManager
{
    const DEFAULT_POSITION = 1;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PageBlockRepository */
    private $blockRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->blockRepository = $this->entityManager->getRepository(PageBlock::class);
    }

    public function get(int $id, bool $check = true): PageBlock
    {
        /** @var $block PageBlock */
        $block = $this->blockRepository->find($id);
        if ($check) {
            $this->checkBlock($block);
        }

        return $block;
    }

    public function getList(Page $page): array
    {
        return $this->blockRepository->findBy(
            ['page' => $page],
            ['position' => 'asc']
        );
    }

    public function getNew(Page $page): PageBlock
    {
        return (new PageBlock())
            ->setPage($page);
    }

    public function save(PageBlock $block, $setPosition = true): PageBlock
    {
        if ($setPosition && !$block->getPosition()) {
            $block->setPosition($this->getNextPosition());
        }

        $this->entityManager->persist($block);
        $this->entityManager->flush();

        return $block;
    }

    private function getNextPosition(): int
    {
        $block = $this->blockRepository->getLast();

        if (!$block) {
            return self::DEFAULT_POSITION;
        }

        return $block->getPosition() + 1;
    }

    public function remove(?PageBlock $block): void
    {
        if (!$block) {
            return;
        }

        $this->entityManager->remove($block);
        $this->entityManager->flush();
    }

    private function checkBlock(?PageBlock $block): void
    {
        if (!$block) {
            throw new NotFoundHttpException('Page Block Not Found.');
        }
    }
}
