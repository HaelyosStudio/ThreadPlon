<?php

namespace App\Repository;

use App\Entity\ResponseVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResponseVote>
 *
 * @method ResponseVote|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseVote|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseVote[]    findAll()
 * @method ResponseVote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseVoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseVote::class);
    }

    //    /**
    //     * @return ResponseVote[] Returns an array of ResponseVote objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ResponseVote
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
