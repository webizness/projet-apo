<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * Obtient un produit avec TOUTES ses relations
     * @return Produit|null
     */
    public function findSingleFullProduit(int $id)
    {
        
        // createQueryBuilder, dans un repository, ajoute déjà le FROM Bar et le SELECT p
        return $this->createQueryBuilder('p')
        
            // Si on ne précise en SQL ou en QB le type de join, on fait un INNER JOIN
            ->leftJoin('p.bar', 'b')
            // Si on veut obtenir les objets bars dans les résultats, il faut ajouter un select
            ->addSelect('b')

            // // Les autres jointures
            //->leftJoin('b.barman', 'e')
            //->addSelect('e')
            //->leftJoin('e.person', 'p')
            //->addSelect('p')

            // On précise qu'on veut un produit selon son id
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

    
    public function findSingleFulltest()
    {
        
        // createQueryBuilder, dans un repository, ajoute déjà le FROM Bar et le SELECT b
        return $this->createQueryBuilder('p')
        
            // Si on ne précise en SQL ou en QB le type de join, on fait un INNER JOIN
            ->leftJoin('p.produits', 'bar')
            // Si on veut obtenir les objets bars dans les résultats, il faut ajouter un select
            ->addSelect('bar')

            // // Les autres jointures
            //->leftJoin('b.barman', 'e')
            //->addSelect('e')
            //->leftJoin('e.person', 'p')
            //->addSelect('p')

            // On précise qu'on veut un produit selon son id
            //->where('p.nom')
            //->setParameter('id', $id)

            ->getQuery()
            // getSingleResult s'attend à retrouver un seul résultat et au moins un résultat
            // Donc s'il n'y a aucun résultat (par exemple lîd n'existe pas), on obtient une erreur
            // On utilise donc getOneOrNullResult() pour autorise à n'avoir aucun résultat et retourner un null si besoin
            // ->getSingleResult()
            ->getOneOrNullResult()
        ;
    }



    public function findCategorieProduit($id,$categorieId)
    {
        //dd($id,$categorieId);
        // createQueryBuilder, dans un repository, ajoute déjà le FROM produit et le SELECT p
        return $this->createQueryBuilder('p')
        
            // Si on ne précise en SQL ou en QB le type de join, on fait un INNER JOIN
            ->leftJoin('p.categories', 'c')
            // Si on veut obtenir les objets bars dans les résultats, il faut ajouter un select
            ->addSelect('c')

            // // Les autres jointures
            ->leftJoin('p.bar', 'b')
            ->addSelect('b')
            //->leftJoin('e.person', 'p')
            //->addSelect('p')
            ->Where('c.id = :idd')
            ->setParameter('idd', $categorieId)
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            // On précise qu'on veut un produit selon son id
            

            ->getQuery()
            // getSingleResult s'attend à retrouver un seul résultat et au moins un résultat
            // Donc s'il n'y a aucun résultat (par exemple lîd n'existe pas), on obtient une erreur
            // On utilise donc getOneOrNullResult() pour autorise à n'avoir aucun résultat et retourner un null si besoin
             ->getResult()
            //->getOneOrNullResult()
        ;
    }
    /*
    public function findOneBySomeField($value): ?Produit
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
