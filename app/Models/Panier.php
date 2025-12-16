<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Panier{

    private $id;
    private $utilisateur_id;
    private $produit_id;
    private $status;

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

    public function getProduitID(){
        return $this->produit_id;
    }

    public function setProduitID($produit_id){
        $this->produit_id = $produit_id;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    /**
     * @return array
     */
    public static function getAll(){
        $pdo = Database::getPDO();
        $stmt = $pdo-query("SELECT * FROM panier ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int
     * @return array|null
     */
    public static function selectAllByID(int $id): array{
        $pdo = Databse::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM panier WHERE utilisateur_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return bool
     */
    public function save(){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO panier(utilisateur_id, produit_id, status) VALUES (?, ?, ?)");
        return $stmt->execute([
            $this->utilisateur_id,
            $this->produit_id,
            $this->status
        ]);
    }

    /**
     * @return bool
     */
    public function update(){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE produit SET utilisateur_id = ?, produit_id = ?, status = ? WHERE id = ?");
        return $stmt->execute([
            $this->utilisateur_id,
            $this->produit_id,
            $this->status,
            $this->id
        ]);
    }
}