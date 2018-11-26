<?php

namespace BoutiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use BoutiqueBundle\Entity\Commande;
use BoutiqueBundle\Entity\Membre;
use BoutiqueBundle\Entity\Produit;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin/show_produits", name="show_produits")
     */
    public function showProduitsAction(){
        // On recupère le service doctrine
        $repository = $this -> getDoctrine() -> getRepository(produit::class);

        $produits = $repository->findAll();

             $params = array (
            'produits' => $produits,
            'title' => 'Gestion produit'
        );
        
        return $this->render('@Boutique/Admin/show_produits.html.twig', $params);

    }

    
    
    /**
     * @Route("/admin/delete_produit/{id}", name="delete_produit")
     */
    public function deleteProduitAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();

        $produit = $em->find(Produit::class, $id);

        $session = $request->getSession();
        if($produit){

            $em->remove($produit);
            $em->flush();

            $session->getFlashbag()->add('success', 'Le produit à bien été supprimé');
        }else{
            $session->getFlashbag()->add('error', 'Le produit n\'existe pas');

        }

        return $this->redirectToRoute('show_produits');
    }



    /**
     * @Route("/admin/show_commandes", name="show_commandes")
     */
    public function showCommandesAction(){

                // On recupère le service doctrine
        $repository = $this -> getDoctrine() -> getRepository(commande::class);

        $commandes = $repository->findAll();

             $params = array (
            'commandes' => $commandes,
            'title' => 'Gestion commandes'
        );

        return $this->render('@Boutique/Admin/show_commandes.html.twig', $params);
    }



    /**
     * @Route("/admin/delete_commandes{id}", name="delete_commandes")
     */
    public function deleteCommandesAction($id, Request $request){


        $session = $request->getSession();
        $session->getFlashbag()->add('success', 'La commande à bien été supprimé');

        return $this->redirectToRoute('delete_commandes');
    }



    /**
     * @Route("/admin/show_membres", name="show_membres")
     */
    public function showMembresAction(){
        // On recupère le service doctrine
        $repository = $this -> getDoctrine() -> getRepository(membre::class);

        $membres = $repository->findAll();

             $params = array (
            'membres' => $membres,
            'title' => 'Gestion membres'
        );

        return $this->render('@Boutique/Admin/show_membres.html.twig', $params);
    }


    
    /**
     * @Route("/admin/delete_membre{id}", name="delete_membre")
     */
    public function deleteMembreAction(){
        
        $session = $request->getSession($id, $request);
        $session->getFlashbag()->add('success', 'Le membre à bien été supprimé');


        return $this->redirectToRoute('show_membres');
    }




















} // Fin class AdminController 