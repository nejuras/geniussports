<?php

namespace App\Repository;

use App\Entity\ScheduleAndResults;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScheduleAndResults|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduleAndResults|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduleAndResults[]    findAll()
 * @method ScheduleAndResults[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleAndResultsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScheduleAndResults::class);
    }

    // /**
    //  * @return ScheduleAndResults[] Returns an array of ScheduleAndResults objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findArray()
    {
//        $query = $this->getDoctrine()
//            ->getRepository('CoreBundle:Categories')
//            ->createQueryBuilder('c')
//            ->getQuery();

        return $this->createQueryBuilder('s')
            ->getQuery()
            ->getArrayResult();
//            ->getOneOrNullResult();
    }
    /*
    public function findOneBySomeField($value): ?ScheduleAndResults
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
