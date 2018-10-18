<?php

namespace App\Repository;

use App\Entity\Slide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SlideRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Slide::class);
    }

    /**
     * @param $limit
     * @return Slide[]
     */
    public function findAllOrderByIdDescAndLimit($limit = 3): array
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();

        return $qb->execute();
    }
}