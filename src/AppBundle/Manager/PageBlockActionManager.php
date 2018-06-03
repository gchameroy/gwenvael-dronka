<?php

namespace AppBundle\Manager;

use AppBundle\Entity\PageBlockAction;
use AppBundle\Repository\PageBlockActionRepository;
use Doctrine\ORM\EntityManagerInterface;

class PageBlockActionManager
{
    const DEFAULT_ACTION = 3;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PageBlockActionRepository */
    private $actionRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->actionRepository = $this->entityManager->getRepository(PageBlockAction::class);
    }

    public function getDefault(): PageBlockAction
    {
        /** @var $action PageBlockAction */
        $action = $this->actionRepository->find(self::DEFAULT_ACTION);
        if (!$action) {
            return null;
        }

        return $action;
    }
}
