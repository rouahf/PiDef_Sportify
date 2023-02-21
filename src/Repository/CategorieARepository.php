<?php

namespace App\Repository;

use App\Entity\CategorieA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieA>
 *
 * @method CategorieA|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieA|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieA[]    findAll()
 * @method CategorieA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieA::class);
    }

    public function save(CategorieA $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CategorieA $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    

/**
   * @return CategorieA[] Returns an array of CategorieA objects
   *   * @param [typeA] $value
    * 
     */
    public function findByTypeA($value): array
   {
       return $this->createQueryBuilder('c')
            ->andWhere('c.typeA= :val')
           ->setParameter('val', $value)
         
          
            ->getQuery()
          ->getResult()
       ;
   } 
//    /**
//     * @return CategorieA[] Returns an array of CategorieA objects
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

//    public function findOneBySomeField($value): ?CategorieA
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
