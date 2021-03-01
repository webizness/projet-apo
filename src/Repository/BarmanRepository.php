<?php

namespace App\Repository;

use App\Entity\Barman;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Barman|null find($id, $lockMode = null, $lockVersion = null)
 * @method Barman|null findOneBy(array $criteria, array $orderBy = null)
 * @method Barman[]    findAll()
 * @method Barman[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BarmanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Barman::class);
    }

    /**
     * Obtient un Barman avec TOUTES ses relations
     * @return Barman|null
     */
    public function findSingleBarman(int $id)
    {
        
        // createQueryBuilder, dans un repository, ajoute déjà le FROM Barman et le SELECT barman
        return $this->createQueryBuilder('b')
        
            // Si on ne précise en SQL ou en QB le type de join, on fait un INNER JOIN
            ->leftJoin('b.bar', 'bar')
            // Si on veut obtenir les objets produits dans les résultats, il faut ajouter un select
            ->addSelect('bar')

            // // Les autres jointures
            //->leftJoin('b.barman', 'e')
            //->addSelect('e')
            //->leftJoin('e.person', 'p')
            //->addSelect('p')

            // On précise qu'on veut un bar selon son id
            ->where('bar.id = :id')
            ->setParameter('id', $id)

            ->getQuery()
            // getSingleResult s'attend à retrouver un seul résultat et au moins un résultat
            // Donc s'il n'y a aucun résultat (par exemple lîd n'existe pas), on obtient une erreur
            // On utilise donc getOneOrNullResult() pour autorise à n'avoir aucun résultat et retourner un null si besoin
            //->getSingleResult()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Barman
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
