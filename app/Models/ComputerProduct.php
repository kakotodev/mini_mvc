<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class ComputerProduct {

    private $id_ordinateur;
    private $nom;
    private $prix;
    private $description;
    private $composants;
    private $stock;
    private $url_img;
    
    public function getIdOrdinateur(){
        return $this->id_ordinateur;
    }

    public function setIdOrdinateur($id_ordinateur){
        $this->id_ordinateur = $id_ordinateur;
    }

    public function getNom(){
        return $this->nom;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setPrix($prix){
        $this->prix = $prix;
    }

    public function getPrix(){
        return $this->prix;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getComposants(){
        return $this->composants;
    }

    public function setComposants($composants){
        $this->composants = $composants;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getUrlImg(){
        return $this->url_img;
    }

    public function setUrlImg($url_img){
        $this->url_img = $url_img;
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->query("SELECT * FROM ordinateurproduit ORDER BY id_ordinateur ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}