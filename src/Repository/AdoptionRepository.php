<?php

namespace App\Repository;

use App\Entity\Adoption;
use App\Entity\Eleveur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adoption>
 */
class AdoptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adoption::class);
    }

//    /**
//     * @return Adoption[] Returns an array of Adoption objects
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

//    public function findOneBySomeField($value): ?Adoption
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findAdoptionsForEleveur(Eleveur $eleveur): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.animal', 'animal')
            ->andWhere('animal.eleveur = :eleveur')
            ->setParameter('eleveur', $eleveur)
            ->orderBy('a.dateDemande', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
