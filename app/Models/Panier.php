<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Panier{

    private $id;
    private $utilisateur_id;
    private $produit_id;
    private $quantity;
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

    public function getQuantity(){
        return $this->quantity;
    }
    
    public function setQuantity($quantity){
        $this->quantity = $quantity;
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
        $stmt = $pdo->query("SELECT * FROM panier ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int
     * @return array|null
     */
    public static function selectAllByID($id) {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM panier WHERE utilisateur_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function showPanierByIDUser($id) {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare(
                            "SELECT ordinateurproduit.nom, ordinateurproduit.prix, ordinateurproduit.url_img, ordinateurproduit.id_ordinateur, ordinateurproduit.composants, panier.id, quantity
                            FROM panier
                            INNER JOIN ordinateurproduit ON panier.produit_id = ordinateurproduit.id_ordinateur
                            WHERE panier.utilisateur_id = ? AND panier.status = 'En cours'");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public static function delete(int $userId, int $panierId): bool {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM panier WHERE utilisateur_id = ? AND id = ?");
        return $stmt->execute([$userId, $panierId]);
    }

    /**
     * @param int $userId
     * @param int $panierId
     * @return bool
     */
    public static function abandon(int $userId, int $panierId): bool {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE panier SET status = 'Abandon' WHERE utilisateur_id = ? AND id = ?");
        return $stmt->execute([$userId, $panierId]);
    }

    /**
     * @return bool
     */
    public function save(){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO panier(utilisateur_id, produit_id, status, quantity) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $this->utilisateur_id,
            $this->produit_id,
            $this->status,
            $this->quantity
        ]);
    }

    /**
     * @return bool
     */
    public function update(){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE panier SET utilisateur_id = ?, produit_id = ?, quantity = ?, status = ? WHERE id = ?");
        return $stmt->execute([
            $this->utilisateur_id,
            $this->produit_id,
            $this->quantity,
            $this->status,
            $this->id
        ]);
    }
}