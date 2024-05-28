<?php

namespace App\Repository;

use App\Entity\AcceptedQuest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AcceptedQuest>
 *
 * @method AcceptedQuest|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcceptedQuest|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcceptedQuest[]    findAll()
 * @method AcceptedQuest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcceptedQuestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcceptedQuest::class);
    }

    //    /**
    //     * @return AcceptedQuest[] Returns an array of AcceptedQuest objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AcceptedQuest
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
