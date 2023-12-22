<?php

namespace App\Repository;

use App\Entity\Habitant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habitant>
 *
 * @method Habitant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habitant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habitant[]    findAll()
 * @method Habitant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habitant::class);
    }

   /**
    * @return Habitant[] Returns an array of Habitant objects
    */
   public function findAllArray(): array
   {
       return $this->createQueryBuilder('u')
           ->select('u.id,u.Nom, u.Prenom,u.DateDeNaissance, h.Adresse as Adresse')
           ->leftJoin('u.habitation', 'h')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Habitant
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
