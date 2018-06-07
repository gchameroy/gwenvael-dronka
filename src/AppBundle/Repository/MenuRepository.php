<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Menu;
use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    /**
     * @return Menu|null
     */
    public function getFirst()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.position', 'asc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Menu|null
     */
    public function getLast()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.position', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Menu[]
     */
    public function getAll()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.position', 'asc')
            ->getQuery()
            ->getResult();
    }
}
