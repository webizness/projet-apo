<?php

namespace App\Repository;

use App\Entity\Bar;
use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function commandeBar($id)
    {
        return $this->createQueryBuilder('c')

            ->leftJoin('c.ligneDeCommandes', 'l')
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

    public function commandeClient($id)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->addSelect('u')
            ->leftJoin('c.ligneDeCommandes', 'l')
            ->addSelect('l')
            ->leftJoin('l.produits', 'p')
            ->addSelect('p')
            ->leftJoin('p.bar', 'b')
            ->addSelect('b')

           
            
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            
        ;
    }
    
}
