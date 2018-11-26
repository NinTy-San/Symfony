<?php

namespace BoutiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use BoutiqueBundle\Entity\Produit;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends Controller

{
    /**

     * @Route("/", name="home")

     */

    public function indexAction()
    {
        // Récupérer les produits (BDD)
        // Select * from produits

        // On recupère le service doctrine

        $repository = $this -> getDoctrine() -> getRepository(produit::class);

        // $repository est de fait le repository correspondant à la classe Produit (donc à la table produit). Et me permet de faire des requêtes sur la tables produit...

        $produits = $repository -> findAll();

        // Récupérer les catégorie du site 
        // ppour utiliser QueryBuilder ou CreateQuery on a besoin du Manager
        $em = $this->getDoctrine()->getManager();

        
        // Méthode QueryBuilder (PHP)
        $query = $em->createQueryBuilder();
        $query->select('p.categorie')->distinct(true)->from(Produit::class, 'p')->orderBy('p.categorie', 'ASC');

        // On bâtit une requête via des fonctions PHP de doctrine
        $categories = $query->getQuery()->getResult();
        // On execute la requête et on fetch.


        // Méthode createQuery (SQL)
        $query = $em->createQuery("SELECT DISTINCT p.categorie From BoutiqueBundle\Entity\Produit p ORDER BY p.categorie");
        // On crée uyne requête SQL via Doctrine 

        $categories = $query->getResult();
        // On execute la requête et on fetch.


        // Transmettre les produits et categorie à la vue
        
        $params = array (
            'produits' => $produits,
            'categories' => $categories,
            'title' => 'Acceuil'
        );
        
        return $this->render('@Boutique/Produit/index.html.twig', $params);
    }
    /**

     * @Route("/produit/{id}", name="produit")

     * WWW.boutique.com/produit/12  ex:

     */

    public function produitAction($id){
        // SELECT * FROM produit WHERE id_produit = $id

        // Méthode 1 :
        // On récupère le repository du produit
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $repository->find($id);

        // Méthode 2 :
        /// On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        // Le patron des differents repository est capable d'intervenir sur toutes les tables.
        // FindAll() n'existe pas sur le Manager.

        $produit = $em->find(Produit::class, $id);


        $categorie = $produit->getCategorie();
        $suggestions = $repository->findBy(['categorie' => $categorie], ['prix' => 'DESC'], 3, 0);


        $params = array (
            'produit' => $produit,
            'title' => 'produit : ' . $produit->getTitre(),
            'suggestions' => $suggestions
        );

        return $this->render('@Boutique/Produit/produit.html.twig', $params);
    }
    /**

     * @Route("/categorie/{cat}", name="categorie")
     * WWW.boutique.com/categorie/t-shirt  ex:
     */
    public function categorieAction($cat){
        // Récupérer les produits (BDD)
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repository->findBy(['categorie' => $cat]);
       
        // Méthode QueryBuilder via ProduitRepository
        $categories = $repository->findAllCategories();
        
        // Méthode CreateQuery via ProduitRepository
        $categories = $repository->findAllCategories2();
        

        // Récupérer les catégorie du site 
        $categories = array (
                0 => array(
                    'categorie' => 'robe'
                ),
                1 => array(
                    'categorie' => 'tshirt'
                )
            );

            $params = array (
                'categories' => $categories,
                'produits' => $produits,
                 'title' => 'categorie' . $cat 
            );

        return $this->render('@Boutique/Produit/index.html.twig', $params);


    }
    /*
     * @Route("/admin/produit/add", name="add_produit")
     * 
     */
    // public function addProduitAction(){
        
        // $produit = new Produit;
        // On instancie un objet de notre EntityProduit. Il nous permet de manipuler un enregistrement dans la table produit

        // $produit
        //         ->setReference('67gb8r')
        //         ->setCategorie('T-Shirt')
        //         ->setTitre('Titre original')
        //         ->setDescription('Super T-shirt original pour l\'été')
        //         ->setCouleur('noir')
        //         ->setTaille('M')
        //         ->setPublic('m')
        //         ->setPhoto('Tupac-Trust-Nobody.jpg')
        //         ->setPrix('29.99')
        //         ->setStock('115');

                // On récupère le manager  pour pouvoir faire une insertion.
                // $em = $this->getDoctrine()->getManager();

                // On prépare l'insertion
                // $em->persist($produit);
                // $produit->setStock(300);
                // On enregistre !!
                // $em->flush();

                // return new Response("OK, le produit est enregistré");
                //test : localhost:8000/admin/produit/add
    // }

    /*
     * @Route("/admin/produit/update/{id}", name="update_produit")
     * 
     */
    // public function updateProduitAction($id){
        // on récupère le produit : 
        // $em = $this->getDoctrine()->getManager(); 
        
        // $produit = $em->find(Produit::class, $id);

        // On modifie une info quelqu'elle soit
        // $produit->setTitre('Trust NoBody');

        // On enregistre : 
        // $em->persist($produit);
        // $em->flush();

        // Message : 
        // return new Response('Le produit n]'.$produit->getIdProduit() .  ' a nien été modifié');
        // test : localhost:/admin/produit/update/11
    // }

    /*
     * @Route("/admin/produit/delete/{id}", name="delete_produit")
     * 
     */
    // public function deleteProduitAction($id, Request $request){
        // on récupère le produit : 
        // $em = $this->getDoctrine()->getManager(); 

        // $produit = $em->find(Produit::class, $id);

        // On supprime :
        // $em->remove($produit);
        // $em->flush();

        // $session = $request->getSession();
        // $session->getFlashbag()->add('success', 'Le  produit a bien été supprimé avec succès');

        // return $this->redirectToRoute('home');

        // test : localhost:8000/admin/produit/delete/12


    // }
    














}//-------FIN class ProduitController extends Controller---------

