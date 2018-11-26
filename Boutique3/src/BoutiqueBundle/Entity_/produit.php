<?php

namespace BoutiqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="produit")
 * 
 * @ORM\Entity(repositoryClass="BoutiqueBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
    * @var int
    * 
    * @ORM\Column(name="id_produit", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;


    /**
    * @var string
    * @ORM\Column(name="reference", type="string", length=20)
    */
    private $reference;


    /**
    * @var string
    * @ORM\Column(name="categorie", type="string", length=20)
    */
    private $categorie;
    

    /**
    * @var string
    * @ORM\Column(name="titre", type="string", length=100)
    */
    private $titre;
    
    
    /**
    * @var string
    * @ORM\Column(name="description", type="string")
    */
    private $description;


    /**
    * @var string
    * @ORM\Column(name="taille", type="string", length=5)
    */
    private $taille;
    
    
    /**
    * @var string
    * @ORM\Column(name="public", type="string", length=5)
    */
    private $public;
    

    /**
    * @var string
    * @ORM\Column(name="couleur", type="string", length=20)
    */
    private $couleur;
    
    
    /**
    * @var float
    * @ORM\Column(name="prix", type="float")
    */
    private $prix;
    
    
    /**
    * @var int
    * @ORM\Column(name="stock", type="integer")
    */
    private $stock;
    
    
    /**
    * @var string
    * @ORM\Column(name="photo", type="string", length=255, nullable=true)
    */
    private $photo;

    /**
     * Get Id
     * @return int
     */
    public function getId(){
        return $this->id;
    }
    /**
     * Set Id
     * @return Produit
     * @param int $arg
     */
    public function setId($arg){
        $this->id = $arg;
        return $this;
    }

    /**
     * Get the value of reference
     *
     * @return  string
     */ 
    public function getReference()
    {
        return $this->reference;
    }
    /**
     * Set the value of reference
     *
     * @param  string  $reference
     *
     * @return  Produit
     */ 
    public function setReference(string $reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get the value of categorie
     *
     * @return  string
     */ 
    public function getCategorie()
    {
        return $this->categorie;
    }
    /**
     * Set the value of categorie
     *
     * @param  string  $categorie
     *
     * @return  Produit
     */ 
    public function setCategorie(string $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }


    /**
     * Get the value of titre
     *
     * @return  string
     */ 
    public function getTitre()
    {
        return $this->titre;
    }
    /**
     * Set the value of titre
     *
     * @param  string  $titre
     *
     * @return  Produit
     */ 
    public function setTitre(string $titre)
    {
        $this->titre = $titre;

        return $this;
    }

    
    /**
     * Get the value of description
     *
     * @return  string
     */ 
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Set the value of description
     *
     * @param  string  $description
     *
     * @return  Produit
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    
    /**
     * Get the value of taille
     *
     * @return  string
     */ 
    public function getTaille()
    {
        return $this->taille;
    }
    /**
     * Set the value of taille
     *
     * @param  string  $taille
     *
     * @return  Produit
     */ 
    public function setTaille(string $taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get the value of public
     *
     * @return  string
     */ 
    public function getPublic()
    {
        return $this->public;
    }
    /**
     * Set the value of public
     *
     * @param  string  $public
     *
     * @return  Produit
     */ 
    public function setPublic(string $public)
    {
        $this->public = $public;

        return $this;
    }

    
    /**
     * Get the value of couleur
     *
     * @return  string
     */ 
    public function getCouleur()
    {
        return $this->couleur;
    }
    /**
     * Set the value of couleur
     *
     * @param  string  $couleur
     *
     * @return  Produit
     */ 
    public function setCouleur(string $couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }


    /**
     * Get the value of prix
     *
     * @return  float
     */ 
    public function getPrix()
    {
        return $this->prix;
    }
    /**
     * Set the value of prix
     *
     * @param  float  $prix
     *
     * @return  Produit
     */ 
    public function setPrix(float $prix)
    {
        $this->prix = $prix;

        return $this;
    }

    
    /**
     * Get the value of stock
     *
     * @return  int
     */ 
    public function getStock()
    {
        return $this->stock;
    }
    /**
     * Set the value of stock
     *
     * @param  int  $stock
     *
     * @return  Produit
     */ 
    public function setStock(int $stock)
    {
        $this->stock = $stock;

        return $this;
    }


    /**
     * Get the value of photo
     *
     * @return  string
     */ 
    public function getPhoto()
    {
        return $this->photo;
    }
    /**
     * Set the value of photo
     *
     * @param  string  $photo
     *
     * @return  Produit
     */ 
    public function setPhoto(string $photo)
    {
        $this->photo = $photo;

        return $this;
    }
}