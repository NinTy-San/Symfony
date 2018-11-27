<?php

namespace BoutiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use BoutiqueBundle\Entity\Commande;
use BoutiqueBundle\Entity\Membre;
use BoutiqueBundle\Entity\Produit;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use BoutiqueBundle\Form\CommandeType;
use BoutiqueBundle\Form\ProduitType;
use BoutiqueBundle\Form\MembreType;

use Symfony\Component\Validator\Constraints as Assert;

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
        $repository = $this -> getDoctrine() -> getRepository(Membre::class);

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

    /**
     * @Route("/admin/add_produit/", name="add_produit")
     * 
     */
    public function addProduitAction(Request $request){
		
		// On créé un objet $produit qui sera hydraté par le formulaire : 
		$produit = new Produit; 
		
		// On créé le formulaire : 
		$form = $this -> createForm(ProduitType::class, $produit);
		
		// Traitements des infos du formulaire : 
		$form -> handleRequest($request);
		
		if($form -> isSubmitted() && $form -> isValid()){
			
			$em = $this -> getDoctrine() -> getManager();
			$em -> persist($produit);
            $produit->uploadPhoto();
            // Cette fonction va enregistrer le fichier photo, après l'avoir renommer, et va également, enreegistrer dans la propriété photo, avec le nom de la photo
			$em -> flush();
            $request -> getSession() -> getFlashBag() -> add('success', 'Le produit <b>' . $produit -> getTitre() . '</b> a été ajouté avec succès !');
				
            return $this -> redirectToRoute('show_produits');
		}
		
		$params = array(
			'title' => 'Ajouter un produit',
			'produitForm' => $form -> createView()
		);
		
		return $this -> render('@Boutique/Admin/form_produit.html.twig', $params);
    }
    
    /**
     * @Route("/admin/update_produit/{id}" , name="update_produit")
     */
    public function updateProduitAction($id, Request $request){

        //je récupère les infos du produit à modifier pour le passer au formulaire :
        $repository = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $repository->find($id);

        // je crée mon formulaire en le liant au produit à modifier
        $form = $this->createForm(ProduitType::class, $produit);

        // On hydrate l'objet $produit des infos saisie dans le formulaire :
        $form->handleRequest($request);

        // Traitement des infos du formulaire
            if($form->isSubmitted() && $form->isValid()){

                $em = $this->getDoctrine()->getManager();
                $em -> persist($produit);
                if($produit->getFile() != NULL){
                    // Avant de traiter la photo du formulaire on vérifie qu'il y enn ait une. Sinon l'ancienne photo sera sauvegardé.
                    $produit->removePhoto();
                    $produit->uploadPhoto();
                }
                $em -> flush();

                $request->getSession()->getFlashBag()->add('success', 'Le produit '.$produit->getTitre() . ' a été modifié avec succès');

                return $this->redirectToRoute('show_produits');
            }

        // Affichage de la vue
        $params = array(
            'title' => 'Modifier le produit n°' . $produit->getIdProduit(), 
            'produitForm' => $form->createView()

        );

        return $this->render("@Boutique/Admin/form_produit.html.twig", $params);
    }
    /**
     * @Route("/admin/membre/{id}", name="profil_client")
     */
    public function profilClientAction($id){
       
        $repo_membre = $this->getDoctrine()->getRepository(Membre::class); 
        $membre = $repo_membre->find($id);
        
        $repo_commande = $this->getDoctrine()->getRepository(Commande::class); 
        $commandes = $repo_commande->findBy(['idMembre' => $id]);

        $params = array(
            'title'     => 'Fiche client',
            'membre'    => $membre,
            'commandes' => $commandes
        );

        return $this->render("@Boutique/Admin/profil_client.html.twig", $params);

    }


} // Fin class AdminController 