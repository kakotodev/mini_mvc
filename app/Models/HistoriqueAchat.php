<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class HistoriqueAchat{

    private $id;
    private $utilisateur_id;
    private $panier_id;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getUtilisateurID(){
        return $this->utilisateur_id;
    }

    public function setUtilisateurID($utilisateur_id){
        $this->utilisateur_id= $utilisateur_id;
    }

    public function getPanierId(){
        return $this->panier_id;
    }

    public function setPanierId($panier_id){
        $this->panier_id = $panier_id;
    }

    /**
     * @return array
     */
    public static function getAll(){
        $pdo = Database::getPDO();
        $stmt = $pdo-query("SELECT * FROM historiqueachat ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int
     * @return array|null
     */
    public static function selectByID(){
        $pdo = Databse::getPDO();
        $stmt = $pdo->query("SELECT * FROM historiqueachat BY ?");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}