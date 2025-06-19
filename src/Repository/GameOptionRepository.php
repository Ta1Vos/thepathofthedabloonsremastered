<?php

namespace App\Repository;

use App\Entity\GameOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameOption>
 *
 * @method GameOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameOption[]    findAll()
 * @method GameOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameOption::class);
    }

    //    /**
    //     * @return GameOption[] Returns an array of GameOption objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GameOption
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
