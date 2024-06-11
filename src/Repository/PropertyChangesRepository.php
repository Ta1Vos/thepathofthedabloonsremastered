<?php

namespace App\Repository;

use App\Entity\PropertyChanges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PropertyChanges>
 *
 * @method PropertyChanges|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyChanges|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyChanges[]    findAll()
 * @method PropertyChanges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyChangesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyChanges::class);
    }

    //    /**
    //     * @return PropertyChanges[] Returns an array of PropertyChanges objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PropertyChanges
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
