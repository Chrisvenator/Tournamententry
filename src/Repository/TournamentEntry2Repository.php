<?php

namespace App\Repository;

use App\Entity\TournamentEntry2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TournamentEntry2|null find($id, $lockMode = null, $lockVersion = null)
 * @method TournamentEntry2|null findOneBy(array $criteria, array $orderBy = null)
 * @method TournamentEntry2[]    findAll()
 * @method TournamentEntry2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentEntry2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TournamentEntry2::class);
    }

    // /**
    //  * @return TournamentEntry2[] Returns an array of TournamentEntry2 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TournamentEntry2
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
