<?php

namespace App\Repository;

use App\Entity\Programa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProgramaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Programa::class);
    }

    /**
     * @param $limit
     * @return Programa[]
     */
    public function findAllOrderByIdDesc($limit = 3): array
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();

        return $qb->execute();
    }
}