<?php

namespace App\Repository;

use App\Entity\InventorySlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InventorySlot>
 *
 * @method InventorySlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method InventorySlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method InventorySlot[]    findAll()
 * @method InventorySlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventorySlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventorySlot::class);
    }

    //    /**
    //     * @return InventorySlot[] Returns an array of InventorySlot objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?InventorySlot
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
