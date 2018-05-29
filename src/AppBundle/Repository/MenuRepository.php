<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function getFirst()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.position', 'asc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getLast()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.position', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getAll()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.position', 'asc')
            ->getQuery()
            ->getResult();
    }
}
