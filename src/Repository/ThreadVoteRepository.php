<?php

namespace App\Repository;

use App\Entity\ThreadVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ThreadVote>
 *
 * @method ThreadVote|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThreadVote|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThreadVote[]    findAll()
 * @method ThreadVote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThreadVoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThreadVote::class);
    }

    //    /**
    //     * @return ThreadVote[] Returns an array of ThreadVote objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ThreadVote
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
