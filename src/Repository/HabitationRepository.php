<?php

namespace App\Repository;

use App\Entity\Habitation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Habitation>
 *
 * @method Habitation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habitation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habitation[]    findAll()
 * @method Habitation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habitation::class);
    }

    public function getAllHomes(): array
    {
        return $this->createQueryBuilder('h')
            ->select('h.id, h.Adresse as Adresse, COUNT(u.id) as NbHabitants, AVG(u.DateDeNaissance) as AgeMoyen')
            ->leftJoin('h.Habitants', 'u')
            ->groupBy('h.id')
            ->getQuery()
            ->getResult()
        ;
    }
    public function getHabitantsForHabitat($habitatId): array
    {
        return $this->createQueryBuilder('h')
            ->select('habitant.id', 'habitant.Prenom', 'habitant.Nom', 'habitant.DateDeNaissance','habitant.Genre')
            ->leftJoin('h.Habitants', 'habitant')
            ->where('h.id = :habitatId')
            ->setParameter('habitatId', $habitatId)
            ->getQuery()
            ->getResult();
    }
}
