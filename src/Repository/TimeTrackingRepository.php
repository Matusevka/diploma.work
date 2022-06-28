<?php

namespace App\Repository;

use App\Entity\TimeTracking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TimeTracking>
 *
 * @method TimeTracking|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeTracking|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeTracking[]    findAll()
 * @method TimeTracking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeTrackingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeTracking::class);
    }

    public function add(TimeTracking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TimeTracking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return TimeTracking[] Returns an array of Tickspot objects
     */
    public function findByMaxUpdatedAt(): array
    {
        return $this->createQueryBuilder('t')
            ->select('MAX(t.updated_at) as date_max')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?TimeTracking
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
