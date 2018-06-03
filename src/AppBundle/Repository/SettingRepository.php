<?php

namespace AppBundle\Repository;

class SettingRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCurrent()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
