<?php

namespace App\Repository;

use App\Entity\GiftsList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GiftsList|null find($id, $lockMode = null, $lockVersion = null)
 * @method GiftsList|null findOneBy(array $criteria, array $orderBy = null)
 * @method GiftsList[]    findAll()
 * @method GiftsList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiftsListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GiftsList::class);
    }

    public function findAllGiftsExceptSelf($userId) {
        return $this->createQueryBuilder('g')
            ->where('g.user = :userid')
            ->setParameter('userid', $userId)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return GiftsList[] Returns an array of GiftsList objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GiftsList
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
