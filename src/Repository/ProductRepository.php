<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param string $value
     * @return Product[] Returns an array of Product objects
     */
    public function findByName(string $value)
    {
        return $this->createQueryBuilder('p')
            ->where('MATCH_AGAINST(p.name) AGAINST(:searchterm boolean)>0')
            ->setParameter('searchterm', $value)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

//        return
//            ->addSelect("MATCH_AGAINST (p.name, :searchterm 'IN NATURAL MODE') as score")
////            ->add('where', 'MATCH_AGAINST(p.name, :searchterm) > 0.5')
//            ->setParameter('searchterm', $value)
//            ->orderBy('score', 'desc')
//            ->setMaxResults(5)
//            ->getQuery()
//            ->getResult();
    }


    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
