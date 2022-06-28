<?php

namespace App\Repository;

use App\Entity\Tickspot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tickspot>
 *
 * @method Tickspot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tickspot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tickspot[]    findAll()
 * @method Tickspot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TickspotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tickspot::class);
    }

    public function add(Tickspot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tickspot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Tickspot[] Returns an array of Tickspot objects
     */
    public function findByMaxUpdatedAt(): array
    {
        return $this->createQueryBuilder('t')
            ->select('MAX(t.updated_at) as date_max')
            ->groupBy('t.updated_at')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Tickspot
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
