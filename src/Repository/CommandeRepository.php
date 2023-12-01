<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
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


    public function facture($id): array
{
    // automatically knows to select Products
    // the "p" is an alias you'll use in the rest of the query
    $qb = $this->createQueryBuilder('c')
        //->select('Distinct c.id as c_id, u.id as user_id, u.email as user_email, u.uti_telephone as user_tel, produit.id as p_id, produit.pro_nom as p_nom, panier.pan_prix_unite as p_prix, panier.pan_quantite as p_quantite, panier.pan_prix_unite * panier.pan_quantite as p_SousTotal, c.com_adresse_facturation as c_adFac, c.com_adresse_livraison as c_adLiv, c.com_date as c_date, c.com_facture_id as c_facId, ad.adr_nom as nom,  ad.adr_prenom as prenom' )
        // ->select('Distinct c.id as c_id, u.id as user_id, u.email as user_email, u.telephone as user_tel, produit.id as p_id, produit.sousrubriqueart as p_nom, panier.prix_unite as p_prix, panier.panier_quantite as p_quantite, panier.prix_unite * panier.panier_quantite as p_SousTotal, c.com_fact_id as c_factId' )
        ->select('Distinct c.id as c_id,u.id as user_id,u.telephone as user_tel  ')
        ->join('c.com_users', 'u')
        // ->join('u.adresses', 'ad')
        // ->join('c.paniers', 'panier')
        //->join('panier.panier_prod', 'produit')
        ->where('c.id = :comId')
        ->setParameter('comId', $id);
    $query = $qb->getQuery();
    return $query->execute();
    //return $query->getResult();

    // to get just one result:
    // $product = $query->setMaxResults(1)->getOneOrNullResult();
}


//    /**
//     * @return Commande[] Returns an array of Commande objects
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

//    public function findOneBySomeField($value): ?Commande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
