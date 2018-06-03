<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Menu;
use AppBundle\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MenuManager
{
    const DEFAULT_POSITION = 1;
    const DIRECTION_UP = 'up';
    const DIRECTION_DOWN = 'down';

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var MenuRepository */
    private $menuRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->menuRepository = $entityManager->getRepository(Menu::class);
    }

    public function get(int $id, bool $check = true): Menu
    {
        /** @var $menu Menu */
        $menu = $this->menuRepository->find($id);
        if ($check) {
            $this->checkMenu($menu);
        }

        return $menu;
    }

    public function getNew(): Menu
    {
        return new Menu();
    }
    
    public function move(Menu $menu, string $direction): Menu
    {
        if (!in_array($direction, [self::DIRECTION_UP, self::DIRECTION_DOWN])) {
            throw new BadRequestHttpException('Bad parameter : position');
        }

        if ($direction === self::DIRECTION_UP) {
            return $this->moveUp($menu);
        }

        return $this->moveDown($menu);
    }
    
    private function moveUp(Menu $menu)
    {
        if ($menu === $this->menuRepository->getFirst()) {
            return $menu;
        }
        
        $menu2 = $this->getPrevious($menu);

        return $this->exchange($menu, $menu2);
    }

    private function getPrevious(Menu $menu): Menu
    {
        /** @var Menu $previousMenu */
        $previousMenu = $this->menuRepository->findOneBy([
            'position' => $menu->getPosition() - 1
        ]);
        $this->checkMenu($previousMenu);

        return $previousMenu;
    }

    private function moveDown(Menu $menu): Menu
    {
        if ($menu === $this->menuRepository->getLast()) {
            return $menu;
        }

        $menu2 = $this->getNext($menu);

        return $this->exchange($menu, $menu2);
    }

    private function getNext(Menu $menu): Menu
    {
        /** @var Menu $nextMenu */
        $nextMenu = $this->menuRepository->findOneBy([
            'position' => $menu->getPosition() + 1
        ]);
        $this->checkMenu($nextMenu);

        return $nextMenu;
    }

    private function exchange(Menu $menu, Menu $menu2): Menu
    {
        $position = $menu->getPosition();
        $position2 = $menu2->getPosition();

        $menu2->setPosition(null);
        $this->save($menu2, false);

        $menu->setPosition($position2);
        $this->save($menu);

        $menu2->setPosition($position);
        $this->save($menu2);

        return $menu;
    }

    public function getList(): array
    {
        return $this->menuRepository->getAll();
    }

    public function save(Menu $menu, bool $setPosition = true): Menu
    {
        if ($setPosition && !$menu->getPosition()) {
            $menu->setPosition($this->getNextPosition());
        }

        $this->entityManager->persist($menu);
        $this->entityManager->flush();

        return $menu;
    }

    private function getNextPosition(): int
    {
        $menu = $this->menuRepository->getLast();

        if (!$menu) {
            return self::DEFAULT_POSITION;
        }

        return $menu->getPosition() + 1;
    }

    public function remove(?Menu $menu): void
    {
        if (!$menu) {
            return;
        }

        $this->entityManager->remove($menu);
        $this->entityManager->flush();
    }

    private function checkMenu(?Menu $menu): void
    {
        if(!$menu) {
            throw new NotFoundHttpException();
        }
    }
}
