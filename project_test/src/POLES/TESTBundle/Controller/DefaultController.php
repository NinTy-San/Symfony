<?php

namespace POLES\TESTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        // return $this->render('POLESTESTBundle:Default:index.html.twig');
        return $this->render('@POLESTEST/Default/index.html.twig');
    }


    /**
     * 
     * @Route("/bonjour")
     * Une route, finalement c'est une URL qui correspond à une méthode
     * 
     * 
     * 
     * 
     */
    public function bonjourAction(){
        // Chaque fonctionnalité du site doit avoir un nom suivi d'action
        echo 'Bonjour';
        // Cela affiche bonjour comme prevu mais il y a une erreur car normalement une route doit avoir une finalité d'affichage
    }
    /**
     * @Route("/bonjour2")
     */
    public function bonjour2(){
        return new Response("Bonjour2");
    }
    /**
     * @Route("/hello/{prenom}")
     */
    public function helloAction($prenom){
        // $prenom va representer prenom qui se trouve dans l'URL
        return new Response('Hello '.$prenom.' !');
        //test : http://localhost:8000/hello/Arnaud
    }
    /**
     * @Route("/hola/{prenom}")
     */
    public function holaAction($prenom){
        $params = array(
            'prenom' => $prenom
        );
        return $this->render('@POLESTEST/Test/hola.html.twig', $params);

    }
    /**
     * @Route("/hi/{prenom}")
     */
    public function hiAction($prenom, Request $request){
        
        $age = $request->query->get('age');
        // Je demande à l'objet request de me récupérer la valeur du paramètre 'age' (?age=) de l'URL
         
        $params = array(
            'prenom'    => $prenom,
            'age'       => $age
        );
        return $this->render("@POLESTEST/Test/hi.html.twig", $params);
    }
}
