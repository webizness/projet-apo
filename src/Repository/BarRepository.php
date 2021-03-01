<?php

namespace App\Repository;

use App\Entity\Bar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\ORM\Query\Expr\GroupBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bar[]    findAll()
 * @method Bar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bar::class);
    }

    // /**
    //  * @return Bar[] Returns an array of Bar objects
    //  */
    
    
    /**
     * Obtient un Bar avec TOUTES ses relations
     * @return Bar|null
     */
    public function findSingleFullBar(int $id)
    {
        
        // createQueryBuilder, dans un repository, ajoute déjà le FROM Bar et le SELECT b
        return $this->createQueryBuilder('b')
        
            // Si on ne précise en SQL ou en QB le type de join, on fait un INNER JOIN
            ->leftJoin('b.produits', 'p')
            // Si on veut obtenir les objets produits dans les résultats, il faut ajouter un select
            ->addSelect('p')

            // // Les autres jointures
            //->leftJoin('b.barman', 'e')
            //->addSelect('e')
            //->leftJoin('e.person', 'p')
            //->addSelect('p')

            // On précise qu'on veut un bar selon son id
            ->where('b.id = :id')
            ->setParameter('id', $id)

            ->getQuery()
            // getSingleResult s'attend à retrouver un seul résultat et au moins un résultat
            // Donc s'il n'y a aucun résultat (par exemple lîd n'existe pas), on obtient une erreur
            // On utilise donc getOneOrNullResult() pour autorise à n'avoir aucun résultat et retourner un null si besoin
            // ->getSingleResult()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Obtient le barman d'un bar
     * @return Bar|null 
     */
    public function findBarmanBar(int $id)
    {
        
        // createQueryBuilder, dans un repository, ajoute déjà le FROM Bar et le SELECT b
        return $this->createQueryBuilder('b')
        
            // Si on ne précise en SQL ou en QB le type de join, on fait un INNER JOIN
            ->leftJoin('b.barmans', 'barman')
            // Si on veut obtenir les objets produits dans les résultats, il faut ajouter un select
            ->addSelect('barman')
            // On précise qu'on veut un bar selon son id
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    
    /*
    public function findOneBySomeField($value): ?Bar
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
