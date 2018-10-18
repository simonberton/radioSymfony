<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @param $limit
     * @return Post[]
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