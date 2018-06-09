<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PageBlockRepository extends EntityRepository
{
    public function getLast()
    {
        return $this->createQueryBuilder('pb')
            ->orderBy('pb.position', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
