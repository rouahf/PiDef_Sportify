<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 *
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    public function save(Cours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   
    public function order_By_Nom()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.nom_cours', 'ASC')
            ->getQuery()->getResult();
    }
    public function findByWeek()
    {
        $startOfWeek = new \DateTime('this week');
        $endOfWeek = clone $startOfWeek;
        $endOfWeek->modify('+1 week');
    
        return $this->createQueryBuilder('s')
            ->andWhere('s.date_cours >= :startOfWeek')
            ->andWhere('s.date_cours < :endOfWeek')
            ->setParameter('startOfWeek', $startOfWeek->format('Y-m-d'))
            ->setParameter('endOfWeek', $endOfWeek->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }
  
    
    public function order_By_Date()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.date_cours', 'ASC')
            ->getQuery()->getResult();
    }

    public function searchNom($nom_cours)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.nom_cours LIKE :ncl')
            ->setParameter('ncl', $nom_cours.'%')
            ->getQuery()
            ->execute();
    }
  

//    /**
//     * @return Cours[] Returns an array of Cours objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cours
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
