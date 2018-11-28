<?php

namespace BoutiqueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

use BoutiqueBundle\Entity\Membre;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use BoutiqueBundle\Form\MembreType;


class MembreController extends Controller
{

    /**
     * @Route("/inscription/", name="inscription")
     */
    public function inscriptionAction(Request $request){

        // Entity :
        $membre = new membre; // Objet vide

        // Formulaire :

            $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $membre);
            // Le createBuilder a besoin de deux infos : 
                                                   // -1 Quel genre de formulaire, 
                                                   // -2 à quelle entité est lié mon formulaire... 

            $formBuilder
                        ->add('pseudo', TextType::class)
                        ->add('mdp', PasswordType::class)
                        ->add('nom', TextType::class)
                        ->add('prenom', TextType::class)
                        ->add('email', EmailType::class)
                        ->add('civilite', ChoiceType::class, array(
                            'choices' => array(
                                'Votre civilité' => '',
                                'Homme' => 'm',
                                'Femme' => 'f'
                            )
                        ))
                        ->add('ville', TextType::class)
                        ->add('codePostal', TextType::class)
                        ->add('adresse', TextType::class)
                        ->add('enregistrer', SubmitType::class);

        
            $form = $formBuilder->getForm();
            // Après avoir configuré notre formulaire, on le récupère.


        // Traitement des infos du formulaire :
            $form->handleRequest($request);
            // Cette ligne permet de lier notre objet $membre, aux infos saisie dans le formulaire.

            if($form->isSubmitted() && $form->isValid()){
                // if(!empty($_POST))
                // + toutes les verifs sur les champs

                $em = $this->getDoctrine()->getmanager();
                $em->persist($membre);
                $em->flush();

                $request->getSession()->getFlashbag()->add('success', 'Felicitations '. $membre->getPseudo() .', Vous êtes inscrit !');
            
                return $this->redirectToroute('connexion');
            }


        // Vue : 
        $params = array(
            'title'         => 'Formulair d\'inscription',
            'membreForm'    => $form->createView()
        );

        return $this->render('@Boutique/Membre/form.html.twig', $params);
        

    }

    /**
     * @Route("/connexion/", name="connexion")
     * 
     */
    public function connexionAction(Request $request){

        $auth = $this->get('security.authentication_utils');

        $lastuserName = $auth->getLastUserName();
        $session = $request->getSession();

        $error = $auth->getLastAuthenticationError();

        // On récupère 3 infos :
        // - le login de l'utilisateur si mauvais MDP
        // - La session pour les flashbags
        // - Les erreurs de connexion

        if(!empty($error)){
            $session->getFlashBag()->add('error', 'Problème d\'identification ! ');
        }

        $params = array(
            'lastUserName'  => $lastuserName,
            'title'         => 'Connexion'
        );
        return $this->render('@Boutique/Membre/connexion.html.twig', $params);
    }

    /**
     * @Route("/deconnexion/", name="deconnexion")
     */
    public function deconnexionAction(){}


    /**
     * @Route("/login_check/", name="login_check")
     */
    public function loginCheckAction(){}


    /**
     * @Route("/profil/update/", name="profil_update")
     */
    public function updateProfilAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $membre = $em->find(Membre::class, '1');

        $form = $this->createForm(MembreType::class, $membre);
        // je récupère un formulaire de la class MembreType et je le lie à mon ibjet memebre.

        $form->handleRequest($request);
        // A partir de maintenant notre objet $membre contient les infos saisie dans le formulaire.
        
        if($form->isSubmitted() && $form->isValid()){

            $em->persit($membre);
            $em->flush();

            $this->getSession()->getFlashBag()->add('success', 'Les informations du profil ont été mise à jour');

            return $this->redirectToRoute('connexion');
        }
        $params = array(
            'title'         => 'Modifictaion de profil',
            'membreForm'    => $form->createView()
        );

        return $this->render('@Boutique/Membre/form.html.twig', $params);



    }
}