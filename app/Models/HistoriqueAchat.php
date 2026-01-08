<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class HistoriqueAchat{

    private $id;
    private $utilisateur_id;
    private $panier_id;
    private $date_achat;

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

    public function getDateAchat(){
        return $this->date_achat;
    }

    public function setDateAchat($date_achat){
        $this->date_achat = $date_achat;
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
    public static function selectByID($id){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM historiqueachat WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getHistoryByUserId($userId) {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("
            SELECT h.id as history_id, h.date_achat, op.nom, op.prix, op.url_img, p.quantity
            FROM historiqueachat h
            JOIN panier p ON h.panier_id = p.id
            JOIN ordinateurproduit op ON p.produit_id = op.id_ordinateur
            WHERE h.utilisateur_id = ?
            ORDER BY h.id DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return bool
     */
    public function save(){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO historiqueachat(utilisateur_id, panier_id, date_achat) VALUES (?, ?, ?)");
        return $stmt->execute([
            $this->utilisateur_id,
            $this->panier_id,
            $this->date_achat
        ]);
    }

    /**
     * @return bool
     */
    public function update(){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE historiqueachat SET utilisateur_id = ?, panier_id = ?, date_achat = ? WHERE id = ?");
        return $stmt->execute([
            $this->utilisateur_id,
            $this->panier_id,
            $this->date_achat,
            $this->id
        ]);
    }
}