<?php

namespace App\Repository;

use App\Entity\LigneDeCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneDeCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneDeCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneDeCommande[]    findAll()
 * @method LigneDeCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneDeCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneDeCommande::class);
    }

    // /**
    //  * @return LigneDeCommande[] Returns an array of LigneDeCommande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneDeCommande
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
   */


  public function commandeClient($id) 
  {
      return $this->createQueryBuilder('l')

          ->leftJoin('l.commandes', 'c')
          ->addSelect('c')

          ->leftJoin('l.produits', 'p')
          ->addSelect('p')
          ->leftJoin('p.bar', 'b')
          ->addSelect('b')
          ->leftJoin('c.user', 'u')
          ->addSelect('u')
          ->andWhere('u.id = :id')
          ->setParameter('id', $id)
          ->getQuery()
          ->getResult()
          
      ;
  }

  public function commandeBar($id)
  {
      return $this->createQueryBuilder('l')

          ->leftJoin('l.commandes', 'c')
          ->addSelect('l')

          ->leftJoin('l.produits', 'p')
          ->addSelect('p')
          ->leftJoin('p.bar', 'b')
          ->addSelect('b')
          ->andWhere('b.id = :id')
          ->setParameter('id', $id)
          ->getQuery()
          ->getResult()
          
      ;
  }
}
